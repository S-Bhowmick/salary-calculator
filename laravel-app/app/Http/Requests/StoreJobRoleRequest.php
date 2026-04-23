<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    public function rules(): array
    {
        return [
            'role_name' => ['required', 'string', 'max:255', 'unique:job_roles,role_name'],
            'base_salary' => ['required', 'integer', 'min:0'],
            'experience_increment' => ['required', 'integer', 'min:0'],
        ];
    }
}