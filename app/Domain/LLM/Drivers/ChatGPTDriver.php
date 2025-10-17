<?php

namespace App\Domain\LLM\Drivers;

use App\Domain\LLM\Contracts\LLMDriverInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatGPTDriver implements LLMDriverInterface
{
    public function __construct(
        private ?string $apiKey,
        private string $model = 'gpt-3.5-turbo',
        private int $maxTokens = 1000,
    ) {}

    public function generateResponse(string $prompt, array $context = []): string
    {
        // Se não temos API key ou é uma chave de teste, usar resposta simulada
        if (empty($this->apiKey) || str_starts_with($this->apiKey, 'sk-test')) {
            return $this->getSimulatedResponse($prompt, $context);
        }

        // Usar a API real do ChatGPT
        return $this->getRealResponse($prompt, $context);
    }

    private function getRealResponse(string $prompt, array $context): string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$this->apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                return $data['choices'][0]['message']['content'] ?? 'Desculpe, não consegui gerar uma resposta.';
            }

            Log::error('OpenAI API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return 'Desculpe, ocorreu um erro ao processar sua solicitação.';
        } catch (\Exception $e) {
            Log::error('OpenAI API exception', [
                'error' => $e->getMessage(),
            ]);

            return 'Desculpe, ocorreu um erro ao processar sua solicitação.';
        }
    }

    private function getSimulatedResponse(string $prompt, array $context): string
    {
        $language = $context['language'] ?? 'pt';
        $sessionId = $context['session_id'] ?? 'default';

        // Usar o TravelTemplateService para guiar o preenchimento
        $templateService = app(\App\Domain\Chat\Services\TravelTemplateService::class);

        // Obter dados atuais da sessão
        $currentData = $this->getCurrentSessionData($sessionId);

        // Verificar se o template está completo
        $status = $templateService->getCompletionStatus($currentData);

        if ($status['is_complete']) {
            return $templateService->getCompletionMessage($language);
        }

        // Extrair informações da mensagem atual (usando o prompt completo)
        $nextField = $templateService->getNextMissingField($currentData, $language);
        $extractedValue = $templateService->extractFieldValue($prompt, $nextField);

        if ($extractedValue) {
            // Guardar o campo que foi preenchido
            $filledField = $nextField;

            // Atualizar dados da sessão
            $currentData[$nextField] = $extractedValue;
            $this->updateSessionData($sessionId, $currentData);

            // Verificar próximo campo
            $nextField = $templateService->getNextMissingField($currentData, $language);

            if ($nextField) {
                $question = $templateService->getFieldQuestion($nextField, $language);
                $progress = $templateService->getCompletionStatus($currentData);

                return match ($language) {
                    'pt' => "Perfeito! Registado: {$templateService->getRequiredFields()[$filledField]} = {$extractedValue}\n\nPróximo: {$question}\n\nProgresso: {$progress['filled']}/{$progress['total']} campos preenchidos",
                    'en' => "Perfect! Recorded: {$templateService->getRequiredFields()[$filledField]} = {$extractedValue}\n\nNext: {$question}\n\nProgress: {$progress['filled']}/{$progress['total']} fields completed",
                    'es' => "¡Perfecto! Registrado: {$templateService->getRequiredFields()[$filledField]} = {$extractedValue}\n\nSiguiente: {$question}\n\nProgreso: {$progress['filled']}/{$progress['total']} campos completados",
                    default => "Perfect! Recorded: {$templateService->getRequiredFields()[$filledField]} = {$extractedValue}\n\nNext: {$question}\n\nProgress: {$progress['filled']}/{$progress['total']} fields completed",
                };
            }
        }

        // Se não conseguiu extrair, perguntar pelo próximo campo
        $question = $templateService->getFieldQuestion($nextField, $language);
        $progress = $templateService->getCompletionStatus($currentData);

        return match ($language) {
            'pt' => "Para criar o seu pacote de viagem, preciso desta informação:\n\n{$question}\n\nProgresso: {$progress['filled']}/{$progress['total']} campos preenchidos",
            'en' => "To create your travel package, I need this information:\n\n{$question}\n\nProgress: {$progress['filled']}/{$progress['total']} fields completed",
            'es' => "Para crear tu paquete de viaje, necesito esta información:\n\n{$question}\n\nProgreso: {$progress['filled']}/{$progress['total']} campos completados",
            default => "To create your travel package, I need this information:\n\n{$question}\n\nProgress: {$progress['filled']}/{$progress['total']} fields completed",
        };
    }

    private function getCurrentSessionData(string $sessionId): array
    {
        $sessionService = app(\App\Domain\Chat\Services\ChatSessionService::class);
        $session = $sessionService->getSession($sessionId);

        return $session ? $session->template_data : [];
    }

    private function updateSessionData(string $sessionId, array $data): void
    {
        $sessionService = app(\App\Domain\Chat\Services\ChatSessionService::class);
        $sessionService->updateTemplateData($sessionId, $data);
    }

    public function getName(): string
    {
        return 'chatgpt';
    }

    public function isAvailable(): bool
    {
        return ! empty($this->apiKey);
    }

    private function buildPrompt(string $prompt, array $context): string
    {
        if (empty($context)) {
            return $prompt;
        }

        $contextString = "Contexto adicional:\n";
        foreach ($context as $key => $value) {
            $contextString .= "- {$key}: {$value}\n";
        }

        return $contextString."\nPergunta: ".$prompt;
    }
}
