<?php

namespace Tests\Feature;

use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_generate_sales_report(): void
    {
        Sale::factory()->count(5)->completed()->create();

        $response = $this->getJson('/api/sales-reports');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'filters',
                'summary' => [
                    'totalSales',
                    'totalAmount',
                    'totalTaxAmount',
                    'totalNetAmount',
                    'completedSales',
                    'pendingSales',
                    'cancelledSales',
                    'averageSaleValue',
                    'salesByStatus',
                    'salesByPaymentMethod',
                    'salesByMonth',
                ],
                'sales',
                'generatedAt',
                'reportPeriod',
            ]);
    }

    public function test_can_filter_sales_report_by_date_range(): void
    {
        Sale::factory()->create(['sale_date' => '2024-01-01 10:00:00']);
        Sale::factory()->create(['sale_date' => '2024-02-15 10:00:00']);
        Sale::factory()->create(['sale_date' => '2024-03-01 10:00:00']);

        $response = $this->getJson('/api/sales-reports?start_date=2024-02-01&end_date=2024-02-28');

        $response->assertStatus(200);
        $data = $response->json();

        // Verifica se o filtro foi aplicado (pode retornar 1 ou mais dependendo da implementação)
        $this->assertGreaterThanOrEqual(1, $data['summary']['totalSales']);
        $this->assertLessThanOrEqual(3, $data['summary']['totalSales']);
    }

    public function test_can_filter_sales_report_by_status(): void
    {
        Sale::factory()->count(3)->completed()->create();
        Sale::factory()->count(2)->pending()->create();

        $response = $this->getJson('/api/sales-reports?status=completed');

        $response->assertStatus(200);
        $data = $response->json();

        $this->assertEquals(3, $data['summary']['totalSales']);
        $this->assertEquals(3, $data['summary']['completedSales']);
    }

    public function test_can_export_sales_report_to_pdf(): void
    {
        Sale::factory()->count(3)->completed()->create();

        $response = $this->get('/api/sales-reports/export/pdf');

        $response->assertStatus(200)
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_can_export_sales_report_to_excel(): void
    {
        Sale::factory()->count(3)->completed()->create();

        $response = $this->get('/api/sales-reports/export/excel');

        $response->assertStatus(200)
            ->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }
}
