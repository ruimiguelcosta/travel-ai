<?php

namespace App\Actions\Http\Budgets;

use App\Models\Budget;
use Illuminate\Http\JsonResponse;

class ShowBudgetAction
{
    public function __invoke(Budget $budget): JsonResponse
    {
        return response()->json($budget->toArray());
    }
}
