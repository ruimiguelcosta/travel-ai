<?php

namespace App\Domain\Budgets\Data;

use Spatie\LaravelData\Data;

class BudgetData extends Data
{
    public function __construct(
        public string $client_name,
        public string $client_email,
        public ?string $client_phone,
        public ?string $client_company,
        public string $client_type,
        public string $service_description,
        public float $amount,
        public ?float $tax_amount,
        public float $total_amount,
        public string $currency,
        public string $status,
        public ?string $valid_until = null,
        public ?array $metadata = null,
    ) {}
}
