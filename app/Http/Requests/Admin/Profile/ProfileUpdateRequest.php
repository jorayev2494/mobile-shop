<?php

namespace App\Http\Requests\Admin\Profile;

use App\Models\Admin;
use App\Models\Auth\AppAuth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return AppAuth::check();
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'min:2', 'max:255'],
            'last_name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email', 'unique:' . Admin::class . ',email,' . AppAuth::id(), 'max:255'],
        ];
    }
}
