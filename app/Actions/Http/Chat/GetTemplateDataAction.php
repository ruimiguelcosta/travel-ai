<?php

namespace App\Actions\Http\Chat;

use App\Domain\Chat\Services\ChatSessionService;
use App\Domain\Chat\Services\TravelTemplateService;
use Illuminate\Http\JsonResponse;

class GetTemplateDataAction
{
    public function __construct(
        private ChatSessionService $sessionService,
        private TravelTemplateService $templateService
    ) {}

    public function __invoke(string $sessionId): JsonResponse
    {
        $session = $this->sessionService->getSession($sessionId);
        
        if (!$session) {
            return response()->json(['error' => 'Session not found'], 404);
        }

        $templateData = $session->template_data ?? [];
        $completionStatus = $this->templateService->getCompletionStatus($templateData);
        $requiredFields = $this->templateService->getRequiredFields();

        $formattedData = [];
        foreach ($requiredFields as $field => $label) {
            $formattedData[] = [
                'field' => $field,
                'label' => $label,
                'value' => $templateData[$field] ?? '',
                'is_filled' => !empty($templateData[$field]),
            ];
        }

        return response()->json([
            'template_data' => $formattedData,
            'completion_status' => $completionStatus,
            'session_id' => $sessionId,
        ]);
    }
}
