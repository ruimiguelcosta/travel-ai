<?php

namespace App\Domain\LLM\Services;

use App\Domain\LLM\Contracts\LLMDriverInterface;
use App\Domain\LLM\Data\LLMResponseData;
use App\Domain\LLM\Drivers\ChatGPTDriver;
use Illuminate\Support\Facades\Log;

class LLMService
{
    private array $drivers = [];

    public function __construct()
    {
        $this->registerDrivers();
    }

    public function generateResponse(string $prompt, string $driverName = 'chatgpt', array $context = []): LLMResponseData
    {
        $driver = $this->getDriver($driverName);

        if (! $driver) {
            throw new \InvalidArgumentException("Driver '{$driverName}' não encontrado");
        }

        if (! $driver->isAvailable()) {
            throw new \RuntimeException("Driver '{$driverName}' não está disponível");
        }

        try {
            $content = $driver->generateResponse($prompt, $context);

            return new LLMResponseData(
                content: $content,
                driver: $driver->getName(),
                metadata: [
                    'prompt_length' => strlen($prompt),
                    'context_count' => count($context),
                    'processed_at' => now()->toISOString(),
                ]
            );
        } catch (\Exception $e) {
            Log::error('LLM Service Error', [
                'driver' => $driverName,
                'error' => $e->getMessage(),
                'prompt_length' => strlen($prompt),
            ]);

            return new LLMResponseData(
                content: 'Erro ao processar solicitação',
                driver: $driverName,
                metadata: [
                    'error' => $e->getMessage(),
                    'processed_at' => now()->toISOString(),
                ],
                error: $e->getMessage()
            );
        }
    }

    public function getAvailableDrivers(): array
    {
        return array_filter($this->drivers, fn ($driver) => $driver->isAvailable());
    }

    public function registerDriver(string $name, LLMDriverInterface $driver): void
    {
        $this->drivers[$name] = $driver;
    }

    private function getDriver(string $name): ?LLMDriverInterface
    {
        return $this->drivers[$name] ?? null;
    }

    private function registerDrivers(): void
    {
        $this->registerDriver('chatgpt', new ChatGPTDriver(
            apiKey: config('services.openai.api_key'),
            model: config('services.openai.model', 'gpt-3.5-turbo'),
            maxTokens: config('services.openai.max_tokens', 1000),
        ));
    }
}
