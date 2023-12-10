<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use App\Models\Address;
use App\Models\Auth\AppAuth;
use App\Models\Card;
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
            'card_uuid'  => ['required', 'string', Rule::exists('client_pgsql.order_cards', 'uuid')],
            'address_uuid'  => ['required', 'string', Rule::exists('client_pgsql.order_addresses', 'uuid')],
            'currency_uuid'  => ['required', 'string', Rule::exists('client_pgsql.order_currencies', 'uuid')],

            'products'  => ['required', 'array'],
            'products.*' => Rule::forEach(
                static fn (array $value, string $attribute): array => [
                    'uuid' => ['required', 'uuid', Rule::exists('client_pgsql.order_products', 'uuid')],
                    'quantity' => ['required', 'integer', 'min:1'],
                ]
            ),

            'email' => ['nullable', 'email'],
            'phone'  => ['nullable', 'string'],
            'note'  => ['nullable', 'string'],
        ];
    }
}
