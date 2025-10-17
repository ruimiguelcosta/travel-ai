<?php

namespace App\Domain\LLM\Contracts;

interface LLMDriverInterface
{
    public function generateResponse(string $prompt, array $context = []): string;

    public function getName(): string;

    public function isAvailable(): bool;
}
