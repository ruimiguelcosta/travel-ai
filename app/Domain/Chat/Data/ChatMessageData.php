<?php

namespace App\Domain\Chat\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class ChatMessageData extends Data
{
    public function __construct(
        public string $message,
        public ?string $language = null,
        #[MapInputName('session_id')]
        public ?string $sessionId = null,
        public ?array $context = null,
    ) {}
}
