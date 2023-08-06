<?php

namespace App\Http\Requests\Client\Cart;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::CLIENT);
    }

    public function rules(): array
    {
        return [
            'products' => [
                'array',
                // Rule::forEach(static function ())
            ],
            'products.*.uuid' => ['string', 'exists:' . \App\Models\Product::class . ',uuid'],
        ];
    }
}
