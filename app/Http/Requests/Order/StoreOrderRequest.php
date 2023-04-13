<?php

namespace App\Http\Requests\Order;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::CLIENT);
    }

    public function rules(): array
    {
        return [
            'email' => ['nullable', 'email'],
            'phone'  => ['nullable', 'string'],
            'country_uuid'  => ['nullable', 'string', 'uuid'],
            'street'  => ['required', 'string'],
            'description'  => ['nullable', 'string'],

            'products'  => ['required', 'array'],
            'products.*' => Rule::forEach(
                static fn (array $value, string $attribute): array => [
                    'product_uuid' => ['required', 'uuid', Rule::exists(Product::class, 'uuid')],
                    'quality' => ['required', 'integer', 'min:1'],
                    'sum' => ['required', 'string'],
                    'discard_sum' => ['required', 'string'],
                ]
            ),

            'quality'  => ['required', 'integer'],
            'sum'  => ['required', 'integer'],
            'discard_sum'  => ['required', 'integer'],
        ];
    }
}