<?php

namespace App\Http\Requests\Admin\Auth\Restore;

use App\Models\Auth\AppAuth;
use Illuminate\Foundation\Http\FormRequest;

class RestorePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::guest();
    }

    public function rules(): array
    {
        return [
            'token' => 'required|string|exists:codes,token',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
