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
            'category_uuid' => ['required', 'string', 'exists:categories,uuid'],
            'currency_uuid' => ['required', 'string', 'exists:currencies,uuid'],
            'price' => ['required', 'string'],
            'discount_presence' => ['nullable', 'string'],
            'medias' => ['required', 'array'],
            'medias.*' => Rule::forEach(static fn (UploadedFile $value, string $attribute, array $attributeValue): array  => ['required', 'file', File::types(ProductMimeType::getValues())]),
            'description' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}