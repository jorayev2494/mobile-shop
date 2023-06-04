<?php

namespace App\Http\Requests\Admin\Auth\Restore;

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
            'email' => ['required', 'email', 'exists:admins,email'],
        ];
    }
}
