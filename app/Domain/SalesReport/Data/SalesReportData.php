<?php

namespace App\Domain\SalesReport\Data;

use Spatie\LaravelData\Data;

class SalesReportData extends Data
{
    public function __construct(
        public SalesReportFilterData $filters,
        public SalesReportSummaryData $summary,
        public array $sales,
        public string $generatedAt,
        public string $reportPeriod,
    ) {}
}
