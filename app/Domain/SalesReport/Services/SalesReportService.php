<?php

namespace App\Domain\SalesReport\Services;

use App\Domain\SalesReport\Data\SalesReportData;
use App\Domain\SalesReport\Data\SalesReportFilterData;
use App\Domain\SalesReport\Data\SalesReportSummaryData;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class SalesReportService
{
    public function generateReport(SalesReportFilterData $filters): SalesReportData
    {
        $query = Sale::query();

        if ($filters->startDate) {
            $query->where('sale_date', '>=', $filters->startDate);
        }

        if ($filters->endDate) {
            $query->where('sale_date', '<=', $filters->endDate);
        }

        if ($filters->status) {
            $query->where('status', $filters->status);
        }

        if ($filters->paymentStatus) {
            $query->where('payment_status', $filters->paymentStatus);
        }

        if ($filters->paymentMethod) {
            $query->where('payment_method', $filters->paymentMethod);
        }

        if ($filters->customerEmail) {
            $query->where('customer_email', 'like', '%'.$filters->customerEmail.'%');
        }

        if ($filters->productName) {
            $query->where('product_name', 'like', '%'.$filters->productName.'%');
        }

        $sales = $query->orderBy('sale_date', 'desc')->get();
        $summary = $this->generateSummary($sales);

        return new SalesReportData(
            filters: $filters,
            summary: $summary,
            sales: $sales->toArray(),
            generatedAt: now()->toISOString(),
            reportPeriod: $this->getReportPeriod($filters),
        );
    }

    private function generateSummary(Collection $sales): SalesReportSummaryData
    {
        $totalSales = $sales->count();
        $totalAmount = $sales->sum('total_amount');
        $totalTaxAmount = $sales->sum('tax_amount');
        $totalNetAmount = $sales->sum('amount');
        $averageSaleValue = $totalSales > 0 ? $totalAmount / $totalSales : 0;

        $completedSales = $sales->where('status', 'completed')->count();
        $pendingSales = $sales->where('status', 'pending')->count();
        $cancelledSales = $sales->where('status', 'cancelled')->count();

        $salesByStatus = $sales->groupBy('status')->map->count()->toArray();
        $salesByPaymentMethod = $sales->groupBy('payment_method')->map->count()->toArray();
        $salesByMonth = $this->groupSalesByMonth($sales);

        return new SalesReportSummaryData(
            totalSales: $totalSales,
            totalAmount: $totalAmount,
            totalTaxAmount: $totalTaxAmount,
            totalNetAmount: $totalNetAmount,
            completedSales: $completedSales,
            pendingSales: $pendingSales,
            cancelledSales: $cancelledSales,
            averageSaleValue: $averageSaleValue,
            salesByStatus: $salesByStatus,
            salesByPaymentMethod: $salesByPaymentMethod,
            salesByMonth: $salesByMonth,
        );
    }

    private function groupSalesByMonth(Collection $sales): array
    {
        return $sales->groupBy(function ($sale) {
            return Carbon::parse($sale->sale_date)->format('Y-m');
        })->map(function ($monthSales) {
            return [
                'count' => $monthSales->count(),
                'total_amount' => $monthSales->sum('total_amount'),
            ];
        })->toArray();
    }

    private function getReportPeriod(SalesReportFilterData $filters): string
    {
        if ($filters->startDate && $filters->endDate) {
            return Carbon::parse($filters->startDate)->format('d/m/Y').' - '.Carbon::parse($filters->endDate)->format('d/m/Y');
        }

        if ($filters->startDate) {
            return 'A partir de '.Carbon::parse($filters->startDate)->format('d/m/Y');
        }

        if ($filters->endDate) {
            return 'Até '.Carbon::parse($filters->endDate)->format('d/m/Y');
        }

        return 'Todos os períodos';
    }
}
