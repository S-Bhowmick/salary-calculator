<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationBonusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    public function rules(): array
    {
        return [
            'location_name' => ['required', 'string', 'max:255', 'unique:location_bonuses,location_name'],
            'bonus_amount' => ['required', 'integer', 'min:0'],
            'estimated_monthly_cost' => ['required', 'integer', 'min:0'],
        ];
    }
}