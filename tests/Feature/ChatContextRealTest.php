<?php

namespace Tests\Feature;

use App\Domain\Chat\Services\ChatSessionService;
use App\Domain\LLM\Services\LLMService;
use App\Jobs\ProcessChatMessageJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatContextRealTest extends TestCase
{
    use RefreshDatabase;

    public function test_chat_maintains_context_in_real_conversation(): void
    {
        $sessionService = app(ChatSessionService::class);
        $session = $sessionService->createSession('pt');

        // Simular primeira mensagem do sistema
        $sessionService->addMessage($session->session_id, 'bot', 'Olá! Sou o seu assistente AI Travel. Vou ajudá-lo a preencher as informações necessárias para criar o seu pacote de viagem. Vamos começar!', 'pt');

        // Simular primeira mensagem do utilizador
        $sessionService->addMessage($session->session_id, 'user', 'ajuda-me a preparar uma viagem para duas pessoas, de rio de janeiro para lisboa em novembro', 'pt');

        // Processar a primeira mensagem
        $job = new ProcessChatMessageJob('ajuda-me a preparar uma viagem para duas pessoas, de rio de janeiro para lisboa em novembro', $session->session_id, 'pt');
        $job->handle(app(LLMService::class));

        // Verificar que a primeira resposta foi gerada
        $messages = $sessionService->getSessionMessages($session->session_id);
        $this->assertGreaterThanOrEqual(3, $messages->count()); // Pelo menos 1 sistema + 1 user + 1 bot

        // Simular segunda mensagem do utilizador (resposta ao nome)
        $sessionService->addMessage($session->session_id, 'user', 'Rui Costa', 'pt');

        // Processar a segunda mensagem
        $job2 = new ProcessChatMessageJob('Rui Costa', $session->session_id, 'pt');
        $job2->handle(app(LLMService::class));

        // Verificar que a segunda resposta foi gerada
        $messages = $sessionService->getSessionMessages($session->session_id);
        $this->assertGreaterThanOrEqual(5, $messages->count()); // Pelo menos 1 sistema + 2 user + 2 bot

        // Verificar que o nome foi extraído e registado
        $session = $sessionService->getSession($session->session_id);
        $this->assertArrayHasKey('full_name', $session->template_data);
        $this->assertEquals('Rui Costa', $session->template_data['full_name']);
    }

    public function test_chat_extracts_information_from_context(): void
    {
        $sessionService = app(ChatSessionService::class);
        $session = $sessionService->createSession('pt');

        // Simular conversa com contexto
        $sessionService->addMessage($session->session_id, 'bot', 'Olá! Sou o seu assistente AI Travel.', 'pt');
        $sessionService->addMessage($session->session_id, 'user', 'ajuda-me a preparar uma viagem para duas pessoas, de rio de janeiro para lisboa em novembro', 'pt');
        $sessionService->addMessage($session->session_id, 'bot', 'Para criar o seu pacote de viagem, preciso desta informação: Qual é o seu nome completo?', 'pt');
        $sessionService->addMessage($session->session_id, 'user', 'Rui Costa', 'pt');

        // Processar a mensagem com contexto
        $job = new ProcessChatMessageJob('Rui Costa', $session->session_id, 'pt');
        $job->handle(app(LLMService::class));

        // Verificar que o nome foi extraído
        $session = $sessionService->getSession($session->session_id);
        $this->assertArrayHasKey('full_name', $session->template_data);
        $this->assertEquals('Rui Costa', $session->template_data['full_name']);

        // Verificar que a próxima pergunta foi feita
        $messages = $sessionService->getSessionMessages($session->session_id);
        $lastMessage = $messages->last();
        $this->assertStringContainsString('email', strtolower($lastMessage->message));
    }
}
