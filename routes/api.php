<?php

use App\Actions\Http\Budgets\IndexBudgetsAction;
use App\Actions\Http\Budgets\ShowBudgetAction;
use App\Actions\Http\Budgets\StoreBudgetAction;
use App\Actions\Http\Budgets\UpdateBudgetAction;
use App\Actions\Http\Chat\CheckResponseAction;
use App\Actions\Http\Chat\GetTemplateDataAction;
use App\Actions\Http\Chat\InitializeChatAction;
use App\Actions\Http\Chat\ProcessMessageAction;
use App\Actions\Http\SalesReports\ExportSalesReportExcelAction;
use App\Actions\Http\SalesReports\ExportSalesReportPdfAction;
use App\Actions\Http\SalesReports\GenerateSalesReportAction;
use App\Actions\Http\TravelRequests\IndexTravelRequestsAction;
use App\Actions\Http\TravelRequests\StoreTravelRequestAction;
use Illuminate\Support\Facades\Route;

Route::prefix('budgets')->group(function () {
    Route::get('/', IndexBudgetsAction::class);
    Route::post('/', StoreBudgetAction::class);
    Route::get('{budget}', ShowBudgetAction::class);
    Route::patch('{budget}', UpdateBudgetAction::class);
});

Route::prefix('travel-requests')->group(function () {
    Route::get('/', IndexTravelRequestsAction::class);
    Route::post('/', StoreTravelRequestAction::class);
});

Route::prefix('sales-reports')->group(function () {
    Route::get('/', GenerateSalesReportAction::class);
    Route::get('/export/pdf', ExportSalesReportPdfAction::class)->name('api.sales-reports.export.pdf');
    Route::get('/export/excel', ExportSalesReportExcelAction::class)->name('api.sales-reports.export.excel');
});

Route::prefix('chat')->group(function () {
    Route::get('/initialize', InitializeChatAction::class);
    Route::post('/message', ProcessMessageAction::class);
    Route::get('/response/{sessionId}', CheckResponseAction::class);
    Route::get('/template/{sessionId}', GetTemplateDataAction::class);
});
