<?php

namespace App\Http\Requests\Admin\Currency;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::ADMIN);
    }

    public function rules(): array
    {
        $uuid = $this->route()->parameter('uuid');

        return [
            'value' => ['required', 'alpha', "unique:admin_pgsql.currency_currencies,value,{$uuid},uuid"],
            'is_active' => ['boolean'],
        ];
    }
}
