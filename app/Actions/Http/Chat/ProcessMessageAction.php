<?php

namespace App\Actions\Http\Chat;

use App\Domain\Chat\Data\ChatMessageData;
use App\Http\Requests\Chat\ProcessMessageRequest;
use App\Jobs\ProcessChatMessageJob;
use Illuminate\Http\JsonResponse;

class ProcessMessageAction
{
    public function __invoke(ProcessMessageRequest $request): JsonResponse
    {
        $messageData = ChatMessageData::from($request->validated());

        // Se não há sessionId válido, criar uma nova sessão
        $sessionId = $messageData->sessionId ?? 'default_session';
        if ($sessionId === 'default_session') {
            $sessionService = app(\App\Domain\Chat\Services\ChatSessionService::class);
            $session = $sessionService->createSession($messageData->language ?? 'pt');
            $sessionId = $session->session_id;
        }

        // Despachar job para processar mensagem com GPT
        ProcessChatMessageJob::dispatch(
            $messageData->message,
            $sessionId,
            $messageData->language ?? 'pt',
            'chatgpt'
        );

        return response()->json([
            'message' => 'Mensagem enviada! Processando resposta...',
            'language' => $messageData->language ?? 'pt',
            'session_id' => $sessionId,
            'type' => 'processing',
            'metadata' => [
                'job_dispatched' => true,
                'timestamp' => now()->toISOString(),
            ],
        ]);
    }
}
