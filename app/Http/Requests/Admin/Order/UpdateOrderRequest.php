<?php

namespace App\Http\Requests\Admin\Order;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::ADMIN);
    }

    public function rules(): array
    {
        return [
            // 'email' => ['email'],
            // 'phone' => ['string'],
            // 'description' => ['required'],
            'status' => ['required', 'string'],
        ];
    }
}
