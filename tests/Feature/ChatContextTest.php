<?php

namespace Tests\Feature;

use App\Domain\Chat\Services\ChatSessionService;
use App\Jobs\ProcessChatMessageJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatContextTest extends TestCase
{
    use RefreshDatabase;

    public function test_chat_maintains_context_between_messages(): void
    {
        $sessionService = app(ChatSessionService::class);
        $session = $sessionService->createSession('pt');

        $sessionService->addMessage($session->session_id, 'user', 'Olá, preciso de ajuda com uma viagem', 'pt');
        $sessionService->addMessage($session->session_id, 'bot', 'Como posso ajudar?', 'pt');
        $sessionService->addMessage($session->session_id, 'user', 'Quero ir para Lisboa', 'pt');

        $messages = $sessionService->getSessionMessages($session->session_id);

        $this->assertCount(3, $messages);

        // Verificar que todas as mensagens estão presentes
        $messageContents = $messages->pluck('message')->toArray();
        $this->assertContains('Olá, preciso de ajuda com uma viagem', $messageContents);
        $this->assertContains('Como posso ajudar?', $messageContents);
        $this->assertContains('Quero ir para Lisboa', $messageContents);
    }

    public function test_conversation_history_is_included_in_prompt(): void
    {
        $sessionService = app(ChatSessionService::class);
        $session = $sessionService->createSession('pt');

        $sessionService->addMessage($session->session_id, 'user', 'Olá, preciso de ajuda', 'pt');
        $sessionService->addMessage($session->session_id, 'bot', 'Como posso ajudar?', 'pt');

        $job = new ProcessChatMessageJob('Quero ir para Lisboa', $session->session_id, 'pt');

        $reflection = new \ReflectionClass($job);
        $method = $reflection->getMethod('getConversationHistory');
        $method->setAccessible(true);

        $history = $method->invoke($job, $sessionService);

        $this->assertCount(2, $history);
        $this->assertEquals('Olá, preciso de ajuda', $history[0]['message']);
        $this->assertEquals('Como posso ajudar?', $history[1]['message']);
    }

    public function test_chat_prompt_includes_conversation_context(): void
    {
        $sessionService = app(ChatSessionService::class);
        $session = $sessionService->createSession('pt');

        $sessionService->addMessage($session->session_id, 'user', 'Olá', 'pt');
        $sessionService->addMessage($session->session_id, 'bot', 'Como posso ajudar?', 'pt');

        $job = new ProcessChatMessageJob('Quero ir para Lisboa', $session->session_id, 'pt');

        $reflection = new \ReflectionClass($job);
        $method = $reflection->getMethod('buildChatPrompt');
        $method->setAccessible(true);

        $prompt = $method->invoke($job, 'Quero ir para Lisboa', 'pt', $sessionService);

        $this->assertStringContainsString('Histórico da conversa:', $prompt);
        $this->assertStringContainsString('Utilizador: Olá', $prompt);
        $this->assertStringContainsString('Assistente: Como posso ajudar?', $prompt);
        $this->assertStringContainsString('Mensagem atual do utilizador: Quero ir para Lisboa', $prompt);
    }
}
