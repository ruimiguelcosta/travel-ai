<?php

namespace App\Actions\Http\SalesReports;

use App\Domain\SalesReport\Data\SalesReportFilterData;
use App\Domain\SalesReport\Services\SalesReportService;
use App\Http\Requests\SalesReports\GenerateSalesReportRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ExportSalesReportPdfAction
{
    public function __construct(private SalesReportService $service) {}

    public function __invoke(GenerateSalesReportRequest $request): Response
    {
        $filters = SalesReportFilterData::from($request->validated());
        $report = $this->service->generateReport($filters);

        $pdf = Pdf::loadView('reports.sales-pdf', compact('report'))
            ->setPaper('a4', 'landscape');

        $filename = 'relatorio-vendas-'.now()->format('Y-m-d-H-i-s').'.pdf';

        return $pdf->download($filename);
    }
}
