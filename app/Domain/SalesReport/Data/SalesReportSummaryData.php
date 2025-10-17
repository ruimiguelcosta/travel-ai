<?php

namespace App\Domain\SalesReport\Data;

use Spatie\LaravelData\Data;

class SalesReportSummaryData extends Data
{
    public function __construct(
        public int $totalSales,
        public float $totalAmount,
        public float $totalTaxAmount,
        public float $totalNetAmount,
        public int $completedSales,
        public int $pendingSales,
        public int $cancelledSales,
        public float $averageSaleValue,
        public array $salesByStatus,
        public array $salesByPaymentMethod,
        public array $salesByMonth,
    ) {}
}
