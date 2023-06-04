<?php

namespace App\Http\Requests\Admin\Auth;

use App\Models\Auth\AppAuth;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::guest();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'x-device-id' => $this->headers->get('x-device-id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'x-device-id' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }
}
