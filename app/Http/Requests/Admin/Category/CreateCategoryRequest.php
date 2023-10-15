<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Category;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::ADMIN);
    }

    public function rules(): array
    {
        return [
            'value' => ['required', 'string', 'unique:admin_pgsql.category_categories,value'],
            'is_active' => ['boolean'],
        ];
    }
}
