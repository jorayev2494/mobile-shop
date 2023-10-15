<?php

namespace App\Http\Requests\Admin\Currency;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;

class CreateCurrencyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::ADMIN);
    }

    public function rules(): array
    {
        return [
            'value' => ['required', 'alpha', 'unique:admin_pgsql.currency_currencies,value'],
            'is_active' => ['boolean'],
        ];
    }
}
