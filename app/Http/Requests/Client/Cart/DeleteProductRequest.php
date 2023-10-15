<?php

declare(strict_types=1);

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

    protected function prepareForValidation()
    {
        $this->merge($this->route()->parameters());
    }

    public function rules(): array
    {

        return [
            'product_uuid' => ['required', 'string', 'exists:client_pgsql.cart_products,uuid'],
        ];
    }
}
