<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use App\Models\Enums\ProductMimeType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::ADMIN);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:225'],
            'category_uuid' => ['required', 'string', 'exists:admin_pgsql.category_categories,uuid'],
            'currency_uuid' => ['required', 'string', 'exists:admin_pgsql.currency_currencies,uuid'],
            'price' => ['required', 'decimal:2'],
            'discount_presence' => ['nullable', 'integer'],
            'medias' => ['required', 'array'],
            // 'medias.*' => Rule::forEach(static fn (UploadedFile $value, string $attribute, array $attributeValue): array  => ['required', 'file', File::types(ProductMimeType::getValues())]),
            // 'medias.*' => Rule::forEach(static function ($value, string $attribute, array $attributeValue): array {
            //     dd($value);

            //     return [];
            // }),

            'description' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
