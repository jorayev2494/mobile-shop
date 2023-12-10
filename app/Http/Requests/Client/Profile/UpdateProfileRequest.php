<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Profile;

use App\Models\Auth\AppAuth;
use App\Models\Client;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::CLIENT);
    }

    public function rules(): array
    {
        return [
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                 Rule::unique('client_pgsql.auth_members', 'email')->ignore(AppAuth::model(AppGuardType::CLIENT)->uuid, 'uuid'),
                'max:255',
            ],
            'phone' => ['nullable', 'string', 'max:255'],
        ];
    }
}
