<?php

namespace App\Actions\Http\Budgets;

use App\Domain\Budgets\Data\BudgetData;
use App\Domain\Budgets\Services\BudgetService;
use App\Http\Requests\Budgets\StoreBudgetRequest;
use Illuminate\Http\JsonResponse;

class StoreBudgetAction
{
    public function __construct(private BudgetService $service) {}

    public function __invoke(StoreBudgetRequest $request): JsonResponse
    {
        $data = BudgetData::from($request->validated());
        $budget = $this->service->store($data);

        return response()->json($budget->toArray(), 201);
    }
}
