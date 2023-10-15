<?php

namespace App\Http\Requests\Client\Cart;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::CLIENT);
    }

    public function rules(): array
    {
        return [
            'product_uuid' => ['required', 'string', 'exists:client_pgsql.cart_products,uuid'],
            'quantity' => ['required', 'numeric', 'min:1'],
        ];
    }
}
