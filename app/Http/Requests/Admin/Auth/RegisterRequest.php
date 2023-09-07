<?php

namespace App\Http\Requests\Admin\Auth;

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
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed', 'min:6'],
            'agree_with_privacy' => ['required', 'accepted'],
        ];
    }
}
