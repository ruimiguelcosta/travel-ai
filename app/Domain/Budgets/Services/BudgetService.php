<?php

namespace App\Domain\Budgets\Services;

use App\Domain\Budgets\Data\BudgetData;
use App\Models\Budget;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BudgetService
{
    public function store(BudgetData $data): Budget
    {
        return DB::transaction(function () use ($data) {
            return Budget::query()->create($data->toArray());
        });
    }

    public function update(Budget $budget, BudgetData $data): Budget
    {
        return DB::transaction(function () use ($budget, $data) {
            $budget->fill($data->toArray())->save();

            return $budget;
        });
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Budget::query()->latest()->paginate($perPage);
    }

    public function findByStatus(string $status): LengthAwarePaginator
    {
        return Budget::query()
            ->byStatus($status)
            ->latest()
            ->paginate(15);
    }

    public function findByClientType(string $clientType): LengthAwarePaginator
    {
        return Budget::query()
            ->byClientType($clientType)
            ->latest()
            ->paginate(15);
    }

    public function findPotentialClients(): LengthAwarePaginator
    {
        return Budget::query()
            ->potentialClients()
            ->latest()
            ->paginate(15);
    }

    public function findClients(): LengthAwarePaginator
    {
        return Budget::query()
            ->clients()
            ->latest()
            ->paginate(15);
    }
}
