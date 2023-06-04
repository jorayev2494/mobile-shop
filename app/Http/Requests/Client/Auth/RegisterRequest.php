<?php

namespace App\Http\Requests\Client\Auth;

use App\Models\Auth\AppAuth;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::guest();
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:clients,email'],
            'phone' => ['required', 'string', 'unique:clients,phone'],
            'password' => ['required', 'string', 'confirmed', 'min:6'],
            'country_uuid' => ['required', 'string', 'exists:countries,uuid'],
        ];
    }
}
