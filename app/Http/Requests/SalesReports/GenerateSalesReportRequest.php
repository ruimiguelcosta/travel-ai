<?php

namespace App\Http\Requests\SalesReports;

use Illuminate\Foundation\Http\FormRequest;

class GenerateSalesReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'string', 'in:pending,completed,cancelled'],
            'payment_status' => ['nullable', 'string', 'in:pending,paid,failed,refunded'],
            'payment_method' => ['nullable', 'string', 'in:credit_card,paypal,bank_transfer,cash'],
            'customer_email' => ['nullable', 'string', 'max:255'],
            'product_name' => ['nullable', 'string', 'max:255'],
        ];
    }
}
