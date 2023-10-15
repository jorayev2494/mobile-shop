<?php

declare(strict_types=1);

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
            'value' => ['required', 'alpha_dash', 'unique:admin_pgsql.country_countries,value'],
            'iso' => ['required', 'alpha_dash', 'unique:admin_pgsql.country_countries,iso', 'max:3'],
            'is_active' => ['boolean'],
        ];
    }
}
