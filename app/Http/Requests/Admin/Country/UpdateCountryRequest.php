<?php

namespace App\Http\Requests\Admin\Country;

use App\Models\Auth\AppAuth;
use App\Models\Country;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::ADMIN);
    }

    public function rules(): array
    {
        $uuid = $this->route()->parameter('uuid');

        return [
            'value' => [
                'required',
                'alpha_dash',
                Rule::unique(Country::class, 'value')->ignore($uuid, 'uuid'),
            ],
            'iso' => [
                'required',
                'alpha_dash',
                Rule::unique(Country::class, 'iso')->ignore($uuid, 'uuid'),
                'max:5',
            ],
            'is_active' => ['boolean'],
        ];
    }
}
