<?php

namespace App\Actions\Http\Chat;

use Illuminate\Http\JsonResponse;

class CheckResponseAction
{
    public function __invoke(string $sessionId): JsonResponse
    {
        $cacheKey = "chat_response_{$sessionId}";
        $response = cache()->get($cacheKey);

        if ($response) {
            // Remover da cache após recuperar
            cache()->forget($cacheKey);

            return response()->json([
                'message' => $response['message'],
                'language' => $response['language'],
                'session_id' => $sessionId,
                'type' => 'response',
                'metadata' => [
                    'timestamp' => $response['timestamp'],
                    'from_cache' => true,
                ],
            ]);
        }

        return response()->json([
            'message' => null,
            'language' => 'pt',
            'session_id' => $sessionId,
            'type' => 'waiting',
            'metadata' => [
                'still_processing' => true,
                'timestamp' => now()->toISOString(),
            ],
        ]);
    }
}
