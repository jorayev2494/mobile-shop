<?php

namespace App\Http\Requests\Admin\Category;

use App\Models\Auth\AppAuth;
use App\Models\Category;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
                'string',
                Rule::unique('admin_pgsql.category_categories', 'value')->ignore($this->route()->parameter('uuid'), 'uuid'),
            ],
            'is_active' => ['boolean'],
        ];
    }
}
