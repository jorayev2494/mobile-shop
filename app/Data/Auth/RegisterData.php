<?php

declare(strict_types=1);

namespace App\Data\Auth;

use App\Data\Contracts\MakeFromFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterData implements MakeFromFormRequest
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly ?string $phone,
        public readonly string $password,
        public readonly ?string $country_uuid,
    ) {
    }

    public static function makeFromFormRequest(FormRequest $request): static
    {
        [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'country_uuid' => $country_uuid,
        ] = $request->validated();

        return new static($first_name, $last_name, $email, $phone, $password, $country_uuid);
    }
}
