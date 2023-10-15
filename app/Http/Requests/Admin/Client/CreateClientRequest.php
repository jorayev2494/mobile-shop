<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Client;

use App\Models\Auth\AppAuth;
use App\Models\Client;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::ADMIN);
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', Rule::unique(Client::class, 'email'), 'max:255'],
            'phone' => ['required', 'string', Rule::unique(Client::class, 'phone'), 'max:255'],
        ];
    }
}
