<?php

namespace App\Actions\Http\Chat;

use App\Domain\Chat\Services\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InitializeChatAction
{
    public function __construct(private ChatService $chatService) {}

    public function __invoke(Request $request): JsonResponse
    {
        $browserLanguage = $request->header('Accept-Language');

        $response = $this->chatService->initializeChat($browserLanguage);

        return response()->json([
            'message' => $response->message,
            'language' => $response->language,
            'session_id' => $response->sessionId,
            'type' => $response->type,
            'metadata' => $response->metadata,
        ]);
    }
}
