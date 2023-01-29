<?php

namespace App\Http\Requests\Auth;

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
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|confirmed|min:6',
        ];
    }
}
