<?php

namespace App\Http\Requests\Client\Card;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::CLIENT);
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'string'],
            'holder_name' => ['required', 'string', 'max:100'],
            'number' => ['required', 'string'],
            'cvv' => ['required', 'string', 'min:3', 'max:3'],
            'expiration_date' => ['required', 'string', 'min:5', 'max:5'],
            'is_active' => ['boolean'],
        ];
    }
}
