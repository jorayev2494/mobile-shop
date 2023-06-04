<?php

namespace App\Http\Requests\Client\Auth\Restore;

use App\Models\Auth\AppAuth;
use Illuminate\Foundation\Http\FormRequest;

class RestorePasswordLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::guest();
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:clients,email'],
        ];
    }
}
