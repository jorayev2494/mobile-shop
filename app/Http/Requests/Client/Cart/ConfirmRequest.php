<?php

declare(strict_types=1);

namespace App\Http\Requests\Client\Cart;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::CLIENT);
    }

    public function rules(): array
    {
        return [
            'card_uuid' => ['required', 'string', 'exists:client_pgsql.card_cards,uuid'],
            'address_uuid' => ['required', 'string', 'exists:client_pgsql.address_addresses,uuid'],
            'currency_uuid' => ['required', 'string', 'exists:client_pgsql.order_currencies,uuid'],
            'email' => ['email'],
            'phone' => ['string'],
            'promo_code' => ['nullable', 'numeric', 'min:4', 'max:6', /** 'exists:client_pgsql.cart_products,uuid' */ ],
            'note' => ['nullable', 'string'],
        ];
    }
}
