<?php

namespace App\Actions\Http\Budgets;

use App\Domain\Budgets\Services\BudgetService;
use Illuminate\Http\JsonResponse;

class IndexBudgetsAction
{
    public function __construct(private BudgetService $service) {}

    public function __invoke(): JsonResponse
    {
        $budgets = $this->service->paginate();

        return response()->json($budgets);
    }
}
