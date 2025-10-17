<?php

namespace App\Http\Requests\Budgets;

use Illuminate\Foundation\Http\FormRequest;

class StoreBudgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['required', 'email', 'max:255'],
            'client_phone' => ['nullable', 'string', 'max:20'],
            'client_company' => ['nullable', 'string', 'max:255'],
            'client_type' => ['required', 'in:potential,client'],
            'service_description' => ['required', 'string', 'max:1000'],
            'amount' => ['required', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'status' => ['required', 'in:draft,sent,approved,rejected,expired'],
            'valid_until' => ['nullable', 'date', 'after:today'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}
