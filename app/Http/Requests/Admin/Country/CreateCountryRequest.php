<?php

namespace App\Http\Requests\Admin\Country;

use App\Models\Auth\AppAuth;
use App\Models\Country;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;

class CreateCountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::ADMIN);
    }

    public function rules(): array
    {
        return [
            'value' => ['required', 'alpha_dash', 'unique:' . Country::class . ',value'],
            'iso' => ['required', 'alpha_dash', 'unique:' . Country::class . ',iso', 'max:3'],
            'is_active' => ['boolean'],
        ];
    }
}
