<?php

namespace App\Http\Requests\Admin\Manager;

use App\Models\Admin;
use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateManagerRequest extends FormRequest
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
                Rule::unique('admin_pgsql.manager_managers', 'email')->ignore($this->route()->parameter('uuid'), 'uuid'),
                'max:255',
            ],
            'role_id' => [
                'required',
                'integer',
                Rule::exists('admin_pgsql.role_roles', 'id'),
                'max:255',
            ],
        ];
    }
}
