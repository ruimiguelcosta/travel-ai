<?php

namespace App\Exports;

use App\Domain\SalesReport\Data\SalesReportData;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReportExport implements FromArray, WithHeadings, WithMapping, WithStyles, WithTitle
{
    public function __construct(private SalesReportData $report) {}

    public function array(): array
    {
        return $this->report->sales;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Cliente',
            'Email',
            'Telefone',
            'Produto',
            'Descrição',
            'Valor',
            'Taxa',
            'Total',
            'Moeda',
            'Status',
            'Método Pagamento',
            'Status Pagamento',
            'Data Venda',
            'Criado em',
        ];
    }

    public function map($sale): array
    {
        return [
            $sale['id'],
            $sale['customer_name'],
            $sale['customer_email'],
            $sale['customer_phone'] ?? '',
            $sale['product_name'],
            $sale['product_description'] ?? '',
            number_format($sale['amount'], 2, ',', '.'),
            number_format($sale['tax_amount'], 2, ',', '.'),
            number_format($sale['total_amount'], 2, ',', '.'),
            $sale['currency'],
            $sale['status'],
            $sale['payment_method'] ?? '',
            $sale['payment_status'],
            \Carbon\Carbon::parse($sale['sale_date'])->format('d/m/Y H:i'),
            \Carbon\Carbon::parse($sale['created_at'])->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Relatório de Vendas';
    }
}
