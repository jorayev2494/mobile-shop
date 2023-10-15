<?php

namespace App\Http\Requests\Admin\Country;

use App\Models\Auth\AppAuth;
use App\Models\Country;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCountryRequest extends FormRequest
{

    private string $uuid;

    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::ADMIN);
    }

    protected function prepareForValidation(): void
    {
        $this->uuid = $this->route()->parameter('uuid');

        $this->merge(['uuid' => $this->uuid]);
    }

    public function rules(): array
    {
        return [
            'uuid' => ['required', Rule::exists(Country::class, 'uuid')],
            'value' => [
                'required',
                'alpha_dash',
                Rule::unique(Country::class, 'value')->ignore($this->uuid, 'uuid'),
            ],
            'iso' => [
                'required',
                'alpha_dash',
                Rule::unique(Country::class, 'iso')->ignore($this->uuid, 'uuid'),
                'max:3',
            ],
            'is_active' => ['boolean'],
        ];
    }
}
