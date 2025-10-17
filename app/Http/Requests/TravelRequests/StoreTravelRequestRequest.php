<?php

namespace App\Http\Requests\TravelRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTravelRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'checkin_date' => ['required', 'date', 'after:today'],
            'checkout_date' => ['required', 'date', 'after:checkin_date'],
            'destination_country' => ['required', 'string', 'max:100'],
            'destination_city' => ['required', 'string', 'max:100'],
            'preferences' => ['required', 'array'],
            'preferences.*' => ['string', 'max:100'],
            'adults' => ['required', 'integer', 'min:1', 'max:10'],
            'children' => ['integer', 'min:0', 'max:10'],
            'budget' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ter um formato válido.',
            'phone.required' => 'O telefone é obrigatório.',
            'checkin_date.required' => 'A data de check-in é obrigatória.',
            'checkin_date.after' => 'A data de check-in deve ser posterior a hoje.',
            'checkout_date.required' => 'A data de check-out é obrigatória.',
            'checkout_date.after' => 'A data de check-out deve ser posterior à data de check-in.',
            'destination_country.required' => 'O país de destino é obrigatório.',
            'destination_city.required' => 'A cidade de destino é obrigatória.',
            'preferences.required' => 'As preferências são obrigatórias.',
            'adults.required' => 'O número de adultos é obrigatório.',
            'adults.min' => 'Deve haver pelo menos 1 adulto.',
        ];
    }
}
