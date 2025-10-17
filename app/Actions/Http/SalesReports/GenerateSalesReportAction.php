<?php

namespace App\Actions\Http\SalesReports;

use App\Domain\SalesReport\Data\SalesReportFilterData;
use App\Domain\SalesReport\Services\SalesReportService;
use App\Http\Requests\SalesReports\GenerateSalesReportRequest;
use Illuminate\Http\JsonResponse;

class GenerateSalesReportAction
{
    public function __construct(private SalesReportService $service) {}

    public function __invoke(GenerateSalesReportRequest $request): JsonResponse
    {
        $filters = SalesReportFilterData::from($request->validated());
        $report = $this->service->generateReport($filters);

        return response()->json($report);
    }
}
