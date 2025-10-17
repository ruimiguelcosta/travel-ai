<?php

namespace Tests\Feature;

use App\Domain\Chat\Services\ChatSessionService;
use App\Domain\Chat\Services\ChatContextService;
use App\Domain\Chat\Services\LanguageDetectionService;
use App\Jobs\ProcessChatMessageJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LanguageDetectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_detects_english_from_user_message(): void
    {
        $sessionService = app(ChatSessionService::class);
        $contextService = app(ChatContextService::class);
        
        $session = $sessionService->createSession('pt');
        
        $detectedLanguage = $contextService->detectAndUpdateLanguage($session->session_id, 'Hello, I need help with my travel');
        
        $this->assertEquals('en', $detectedLanguage);
        
        $context = $contextService->getContext($session->session_id);
        $this->assertEquals('en', $context['detected_language']);
        $this->assertGreaterThan(0.3, $context['language_confidence']);
    }

    public function test_detects_spanish_from_user_message(): void
    {
        $sessionService = app(ChatSessionService::class);
        $contextService = app(ChatContextService::class);
        
        $session = $sessionService->createSession('pt');
        
        $detectedLanguage = $contextService->detectAndUpdateLanguage($session->session_id, 'Hola, necesito ayuda con mi viaje');
        
        $this->assertEquals('es', $detectedLanguage);
        
        $context = $contextService->getContext($session->session_id);
        $this->assertEquals('es', $context['detected_language']);
        $this->assertGreaterThan(0.3, $context['language_confidence']);
    }

    public function test_detects_french_from_user_message(): void
    {
        $sessionService = app(ChatSessionService::class);
        $contextService = app(ChatContextService::class);
        
        $session = $sessionService->createSession('pt');
        
        $detectedLanguage = $contextService->detectAndUpdateLanguage($session->session_id, 'Bonjour, j\'ai besoin d\'aide avec mon voyage');
        
        $this->assertEquals('fr', $detectedLanguage);
        
        $context = $contextService->getContext($session->session_id);
        $this->assertEquals('fr', $context['detected_language']);
        $this->assertGreaterThan(0.3, $context['language_confidence']);
    }

    public function test_chat_responds_in_detected_language(): void
    {
        $sessionService = app(ChatSessionService::class);
        $session = $sessionService->createSession('pt');
        
        $job = new ProcessChatMessageJob('Hello, I need help with my travel', $session->session_id, 'pt');
        $job->handle(app(\App\Domain\LLM\Services\LLMService::class));
        
        $messages = $sessionService->getSessionMessages($session->session_id);
        $lastMessage = $messages->last();
        
        $this->assertEquals('bot', $lastMessage->type);
        $this->assertEquals('en', $lastMessage->language);
        $this->assertStringContainsString('What is your full name?', $lastMessage->message);
    }

    public function test_chat_switches_language_during_conversation(): void
    {
        $sessionService = app(ChatSessionService::class);
        $session = $sessionService->createSession('pt');
        
        // Primeira mensagem em português
        $job1 = new ProcessChatMessageJob('Olá, preciso de ajuda com a minha viagem', $session->session_id, 'pt');
        $job1->handle(app(\App\Domain\LLM\Services\LLMService::class));
        
        $messages = $sessionService->getSessionMessages($session->session_id);
        $firstResponse = $messages->last();
        
        $this->assertEquals('pt', $firstResponse->language);
        $this->assertStringContainsString('Qual é o seu nome completo?', $firstResponse->message);
        
        // Segunda mensagem em inglês
        $job2 = new ProcessChatMessageJob('Hello, I want to go to Paris', $session->session_id, 'pt');
        $job2->handle(app(\App\Domain\LLM\Services\LLMService::class));
        
        $messages = $sessionService->getSessionMessages($session->session_id);
        $secondResponse = $messages->last();
        
        $this->assertEquals('en', $secondResponse->language);
        $this->assertStringContainsString('What is your full name?', $secondResponse->message);
    }

    public function test_language_detection_service_accuracy(): void
    {
        $service = app(LanguageDetectionService::class);
        
        $testCases = [
            ['message' => 'Hello, how are you?', 'expected' => 'en'],
            ['message' => 'Hola, ¿cómo estás?', 'expected' => 'es'],
            ['message' => 'Olá, como estás?', 'expected' => 'pt'],
            ['message' => 'Bonjour, comment allez-vous?', 'expected' => 'fr'],
            ['message' => 'Ciao, come stai?', 'expected' => 'it'],
        ];
        
        foreach ($testCases as $testCase) {
            $detected = $service->detectLanguage($testCase['message']);
            $this->assertEquals($testCase['expected'], $detected, 
                "Failed to detect language for: '{$testCase['message']}'");
        }
    }
}
