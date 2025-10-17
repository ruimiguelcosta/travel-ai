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
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$this->apiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Você é um especialista em turismo e viagens. Forneça informações úteis e precisas sobre destinos, hotéis, atividades e orçamentos de viagem.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $this->buildPrompt($prompt, $context),
                    ],
                ],
                'max_tokens' => $this->maxTokens,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                return $data['choices'][0]['message']['content'] ?? 'Resposta não disponível';
            }

            Log::error('ChatGPT API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return 'Erro ao comunicar com o ChatGPT';
        } catch (\Exception $e) {
            Log::error('ChatGPT Driver Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return 'Erro interno ao comunicar com o ChatGPT';
        }
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
