<?php

namespace App\Http\Requests\Budgets;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBudgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_name' => ['sometimes', 'string', 'max:255'],
            'client_email' => ['sometimes', 'email', 'max:255'],
            'client_phone' => ['nullable', 'string', 'max:20'],
            'client_company' => ['nullable', 'string', 'max:255'],
            'client_type' => ['sometimes', 'in:potential,client'],
            'service_description' => ['sometimes', 'string', 'max:1000'],
            'amount' => ['sometimes', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'total_amount' => ['sometimes', 'numeric', 'min:0'],
            'currency' => ['sometimes', 'string', 'size:3'],
            'status' => ['sometimes', 'in:draft,sent,approved,rejected,expired'],
            'valid_until' => ['nullable', 'date', 'after:today'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}
