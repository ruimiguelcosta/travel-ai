<?php

namespace App\Domain\SalesReport\Data;

use Spatie\LaravelData\Data;

class SalesReportFilterData extends Data
{
    public function __construct(
        public ?string $startDate = null,
        public ?string $endDate = null,
        public ?string $status = null,
        public ?string $paymentStatus = null,
        public ?string $paymentMethod = null,
        public ?string $customerEmail = null,
        public ?string $productName = null,
    ) {}
}
