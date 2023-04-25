<?php

namespace App\Http\Requests\Client\Address;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::CLIENT);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'full_name' => ['required', 'string'],
            'first_address' => ['required', 'string'],
            'second_address' => ['string'],
            'zip_code' => ['required', 'string'],
            'country_uuid' => ['required', 'string', Rule::exists('countries', 'uuid')],
            'city_uuid' => ['required', 'string', Rule::exists('cities', 'uuid')],
            'district' => ['required', 'string'],
            'is_active' => ['boolean'],
        ];
    }
}
