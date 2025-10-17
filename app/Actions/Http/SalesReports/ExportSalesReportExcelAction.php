<?php

namespace App\Actions\Http\SalesReports;

use App\Domain\SalesReport\Data\SalesReportFilterData;
use App\Domain\SalesReport\Services\SalesReportService;
use App\Exports\SalesReportExport;
use App\Http\Requests\SalesReports\GenerateSalesReportRequest;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportSalesReportExcelAction
{
    public function __construct(private SalesReportService $service) {}

    public function __invoke(GenerateSalesReportRequest $request): BinaryFileResponse
    {
        $filters = SalesReportFilterData::from($request->validated());
        $report = $this->service->generateReport($filters);

        $filename = 'relatorio-vendas-'.now()->format('Y-m-d-H-i-s').'.xlsx';

        return Excel::download(new SalesReportExport($report), $filename);
    }
}
