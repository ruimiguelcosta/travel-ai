<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;

class ProcessMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:2000'],
            'language' => ['nullable', 'string', 'max:5'],
            'session_id' => ['nullable', 'string', 'max:100'],
            'context' => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'A mensagem é obrigatória.',
            'message.max' => 'A mensagem não pode ter mais de 2000 caracteres.',
            'language.max' => 'O código do idioma não pode ter mais de 5 caracteres.',
            'session_id.max' => 'O ID da sessão não pode ter mais de 100 caracteres.',
        ];
    }
}
