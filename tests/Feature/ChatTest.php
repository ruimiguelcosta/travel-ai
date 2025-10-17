<?php

namespace Tests\Feature;

use App\Domain\Chat\Services\ChatGreetingService;
use App\Domain\Chat\Services\ChatService;
use App\Domain\LLM\Services\LLMService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_initialize_chat_with_portuguese_language(): void
    {
        $response = $this->getJson('/api/chat/initialize', [
            'Accept-Language' => 'pt-PT,pt;q=0.9,en;q=0.8',
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'message',
                'language',
                'session_id',
                'type',
                'metadata',
            ])
            ->assertJsonPath('language', 'pt')
            ->assertJsonPath('type', 'greeting');
    }

    public function test_can_initialize_chat_with_english_language(): void
    {
        $response = $this->getJson('/api/chat/initialize', [
            'Accept-Language' => 'en-US,en;q=0.9',
        ]);

        $response->assertOk()
            ->assertJsonPath('language', 'en')
            ->assertJsonPath('type', 'greeting');
    }

    public function test_can_initialize_chat_with_spanish_language(): void
    {
        $response = $this->getJson('/api/chat/initialize', [
            'Accept-Language' => 'es-ES,es;q=0.9',
        ]);

        $response->assertOk()
            ->assertJsonPath('language', 'es')
            ->assertJsonPath('type', 'greeting');
    }

    public function test_can_process_chat_message(): void
    {
        config(['services.openai.api_key' => 'test-key']);

        $payload = [
            'message' => 'Olá, preciso de ajuda para planear uma viagem',
            'language' => 'pt',
            'session_id' => 'test_session_123',
        ];

        $response = $this->postJson('/api/chat/message', $payload);

        $response->assertOk()
            ->assertJsonStructure([
                'message',
                'language',
                'session_id',
                'type',
                'metadata',
            ])
            ->assertJsonPath('language', 'pt')
            ->assertJsonPath('session_id', 'test_session_123')
            ->assertJsonPath('type', 'response');
    }

    public function test_validates_required_message_field(): void
    {
        $response = $this->postJson('/api/chat/message', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['message']);
    }

    public function test_validates_message_max_length(): void
    {
        $payload = [
            'message' => str_repeat('a', 2001),
        ];

        $response = $this->postJson('/api/chat/message', $payload);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['message']);
    }

    public function test_chat_greeting_service_detects_language_correctly(): void
    {
        $service = new ChatGreetingService;

        $this->assertEquals('pt', $service->detectLanguage('pt-PT,pt;q=0.9'));
        $this->assertEquals('en', $service->detectLanguage('en-US,en;q=0.9'));
        $this->assertEquals('es', $service->detectLanguage('es-ES,es;q=0.9'));
        $this->assertEquals('fr', $service->detectLanguage('fr-FR,fr;q=0.9'));
        $this->assertEquals('de', $service->detectLanguage('de-DE,de;q=0.9'));
        $this->assertEquals('it', $service->detectLanguage('it-IT,it;q=0.9'));
        $this->assertEquals('en', $service->detectLanguage('invalid-language'));
        $this->assertEquals('en', $service->detectLanguage(null));
    }

    public function test_chat_greeting_service_generates_correct_greeting(): void
    {
        $service = new ChatGreetingService;

        $greeting = $service->generateGreeting('pt-PT');

        $this->assertArrayHasKey('language', $greeting);
        $this->assertArrayHasKey('greeting', $greeting);
        $this->assertArrayHasKey('welcome_message', $greeting);
        $this->assertArrayHasKey('full_message', $greeting);
        $this->assertArrayHasKey('time_of_day', $greeting);
        $this->assertEquals('pt', $greeting['language']);
        $this->assertStringContainsString('assistente AI Travel', $greeting['welcome_message']);
    }

    public function test_chat_greeting_service_returns_supported_languages(): void
    {
        $service = new ChatGreetingService;

        $languages = $service->getSupportedLanguages();

        $this->assertIsArray($languages);
        $this->assertContains('pt', $languages);
        $this->assertContains('en', $languages);
        $this->assertContains('es', $languages);
        $this->assertContains('fr', $languages);
        $this->assertContains('de', $languages);
        $this->assertContains('it', $languages);
    }

    public function test_chat_service_initializes_chat_correctly(): void
    {
        config(['services.openai.api_key' => 'test-key']);

        $greetingService = new ChatGreetingService;
        $llmService = new LLMService;
        $chatService = new ChatService($greetingService, $llmService);

        $response = $chatService->initializeChat('pt-PT');

        $this->assertStringContainsString('assistente AI Travel', $response->message);
        $this->assertEquals('pt', $response->language);
        $this->assertEquals('greeting', $response->type);
        $this->assertNotNull($response->sessionId);
    }

    public function test_chat_service_processes_message_correctly(): void
    {
        config(['services.openai.api_key' => 'test-key']);

        $greetingService = new ChatGreetingService;
        $llmService = new LLMService;
        $chatService = new ChatService($greetingService, $llmService);

        $messageData = new \App\Domain\Chat\Data\ChatMessageData(
            message: 'Preciso de ajuda com uma viagem',
            language: 'pt',
            sessionId: 'test_session'
        );

        $response = $chatService->processMessage($messageData);

        $this->assertEquals('pt', $response->language);
        $this->assertEquals('test_session', $response->sessionId);
        $this->assertEquals('response', $response->type);
        $this->assertNotNull($response->message);
    }
}
