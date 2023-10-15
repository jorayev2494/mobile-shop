<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Auth\Restore;

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
            'code' => 'required|integer',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
