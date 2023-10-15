<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Auth\Restore;

use App\Models\Auth\AppAuth;
use App\Models\Client;
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
            'email' => ['required', 'email', 'exists:' . Client::class . ',email'],
        ];
    }
}
