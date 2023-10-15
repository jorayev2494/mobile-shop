<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Profile;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::ADMIN);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'x-device-id' => $this->headers->get('x-device-id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'x-device-id' => ['required', 'string'],
            'current_password' => ['required', 'string', 'min:6'],
            'password' => ['required', 'string', 'confirmed', 'min:6'],
        ];
    }
}
