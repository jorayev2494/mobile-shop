<?php

namespace App\Http\Requests\Admin\Category;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::ADMIN);
    }

    public function rules(): array
    {
        return [
            'value' => ['required', 'string', 'unique:categories,value'],
            'is_active' => ['boolean'],
        ];
    }
}
