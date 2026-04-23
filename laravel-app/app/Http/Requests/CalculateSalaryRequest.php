<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculateSalaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'jobTitle' => ['required', 'string'],
            'experience' => ['required', 'integer', 'min:0', 'max:50'],
            'location' => ['required', 'string'],
            'rent' => ['nullable', 'numeric', 'min:0'],
            'food' => ['nullable', 'numeric', 'min:0'],
            'transport' => ['nullable', 'numeric', 'min:0'],
            'bills' => ['nullable', 'numeric', 'min:0'],
            'other' => ['nullable', 'numeric', 'min:0'],
            'savings_goal' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}