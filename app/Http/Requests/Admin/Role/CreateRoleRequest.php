<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Role;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::ADMIN);
    }

    public function rules(): array
    {
        return [
            'value' => [
                'required',
                'alpha_dash',
                // Rule::unique('roles', 'value'),
            ],
            'permissions' => [
                'array',
                // Rule::exists('permissions', 'id'),
            ],
        ];
    }
}
