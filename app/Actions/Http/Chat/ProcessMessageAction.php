<?php

namespace App\Actions\Http\Chat;

use App\Domain\Chat\Data\ChatMessageData;
use App\Domain\Chat\Services\ChatService;
use App\Http\Requests\Chat\ProcessMessageRequest;
use Illuminate\Http\JsonResponse;

class ProcessMessageAction
{
    public function __construct(private ChatService $chatService) {}

    public function __invoke(ProcessMessageRequest $request): JsonResponse
    {
        $messageData = ChatMessageData::from($request->validated());

        $response = $this->chatService->processMessage($messageData);

        return response()->json([
            'message' => $response->message,
            'language' => $response->language,
            'session_id' => $response->sessionId,
            'type' => $response->type,
            'suggestions' => $response->suggestions,
            'metadata' => $response->metadata,
        ]);
    }
}
