<?php

namespace App\Http\Requests\Order;

use App\Models\Address;
use App\Models\Auth\AppAuth;
use App\Models\Card;
use App\Models\Enums\AppGuardType;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
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
            'description'  => ['nullable', 'string'],
            'card_uuid'  => ['required', 'string', Rule::exists(Card::class, 'uuid')],
            'address_uuid'  => ['required', 'string', Rule::exists(Address::class, 'uuid')],

            'products'  => ['required', 'array'],
            'products.*' => Rule::forEach(
                static fn (array $value, string $attribute): array => [
                    'uuid' => ['required', 'uuid', Rule::exists(OrderProduct::class, 'uuid')],
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
