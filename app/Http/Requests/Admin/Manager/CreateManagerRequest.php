<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Manager;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateManagerRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                Rule::unique('admin_pgsql.manager_managers', 'email'),
                'max:255',
            ],
            'role_id' => [
                'required',
                'integer',
                Rule::exists('admin_pgsql.auth_roles', 'id'),
                'max:255',
            ],
        ];
    }
}
