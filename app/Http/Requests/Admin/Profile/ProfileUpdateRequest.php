<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Profile;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check(AppGuardType::ADMIN);
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2', 'max:255'],
            'last_name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'avatar' => ['file', 'mimetypes:image/*'],
            'phone' => ['nullable', 'string', 'min:2', 'max:255'],
        ];
    }
}
