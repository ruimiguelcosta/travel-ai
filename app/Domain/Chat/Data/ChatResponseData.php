<?php

namespace App\Domain\Chat\Data;

use Spatie\LaravelData\Data;

class ChatResponseData extends Data
{
    public function __construct(
        public string $message,
        public string $language,
        public ?string $sessionId = null,
        public ?array $suggestions = null,
        public ?array $metadata = null,
        public ?string $type = 'text',
    ) {}
}
