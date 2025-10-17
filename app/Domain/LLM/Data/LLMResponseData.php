<?php

namespace App\Domain\LLM\Data;

use Spatie\LaravelData\Data;

class LLMResponseData extends Data
{
    public function __construct(
        public string $content,
        public string $driver,
        public array $metadata = [],
        public ?string $error = null,
    ) {}
}
