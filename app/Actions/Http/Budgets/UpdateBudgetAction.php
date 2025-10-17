<?php

namespace App\Actions\Http\Budgets;

use App\Domain\Budgets\Data\BudgetData;
use App\Domain\Budgets\Services\BudgetService;
use App\Http\Requests\Budgets\UpdateBudgetRequest;
use App\Models\Budget;
use Illuminate\Http\JsonResponse;

class UpdateBudgetAction
{
    public function __construct(private BudgetService $service) {}

    public function __invoke(UpdateBudgetRequest $request, Budget $budget): JsonResponse
    {
        $validatedData = $request->validated();
        $mergedData = array_merge($budget->toArray(), $validatedData);

        $data = BudgetData::from($mergedData);
        $budget = $this->service->update($budget, $data);

        return response()->json($budget->toArray());
    }
}
