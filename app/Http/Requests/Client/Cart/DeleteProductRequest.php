<?php

namespace App\Http\Requests\Client\Cart;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;

class DeleteProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::CLIENT);
    }

    public function rules(): array
    {
        return [
            'product_uuid' => ['required', 'string', 'exists:' . \App\Models\Product::class . ',uuid'],

            // 'product_currency_uuid' => ['required', 'string', 'exists:' . \App\Models\Product::class . ',currency_uuid'],
            // 'product_quality' => ['required', 'integer'],
            // 'product_price' => ['required', 'string', 'exists:' . \App\Models\Product::class . ',price'],
            // 'product_discount_percentage' => ['required'],
        ];
    }
}
