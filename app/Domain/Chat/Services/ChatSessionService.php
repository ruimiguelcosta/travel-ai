<?php

namespace App\Domain\Chat\Services;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use Illuminate\Support\Str;

class ChatSessionService
{
    public function createSession(string $language = 'pt'): ChatSession
    {
        $sessionId = 'chat_'.Str::uuid()->toString().'_'.now()->timestamp;

        return ChatSession::query()->create([
            'session_id' => $sessionId,
            'language' => $language,
            'template_data' => [],
            'is_complete' => false,
            'started_at' => now(),
        ]);
    }

    public function getSession(string $sessionId): ?ChatSession
    {
        return ChatSession::query()->where('session_id', $sessionId)->first();
    }

    public function addMessage(string $sessionId, string $type, string $message, string $language = 'pt', array $metadata = []): ChatMessage
    {
        return ChatMessage::query()->create([
            'session_id' => $sessionId,
            'type' => $type,
            'message' => $message,
            'language' => $language,
            'metadata' => $metadata,
            'sent_at' => now(),
        ]);
    }

    public function updateTemplateData(string $sessionId, array $templateData): void
    {
        ChatSession::query()
            ->where('session_id', $sessionId)
            ->update(['template_data' => $templateData]);
    }

    public function markAsComplete(string $sessionId): void
    {
        ChatSession::query()
            ->where('session_id', $sessionId)
            ->update([
                'is_complete' => true,
                'completed_at' => now(),
            ]);
    }

    public function getSessionMessages(string $sessionId): \Illuminate\Database\Eloquent\Collection
    {
        return ChatMessage::query()
            ->where('session_id', $sessionId)
            ->orderBy('sent_at')
            ->get();
    }

    public function getRecentSessions(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return ChatSession::query()
            ->orderBy('started_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function updateSessionData(string $sessionId, array $data): void
    {
        $session = $this->getSession($sessionId);
        if ($session) {
            $currentData = $session->template_data ?? [];
            $updatedData = array_merge($currentData, $data);

            $this->updateTemplateData($sessionId, $updatedData);
        }
    }

    public function getSessionData(string $sessionId): array
    {
        $session = $this->getSession($sessionId);

        return $session ? ($session->template_data ?? []) : [];
    }
}
