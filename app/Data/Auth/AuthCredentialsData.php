<?php

declare(strict_types=1);

namespace App\Data\Auth;

use App\Data\Contracts\MakeFromFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class AuthCredentialsData implements MakeFromFormRequest
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $device_id,
    ) {
    }

    public static function makeFromFormRequest(FormRequest $request): static
    {
        ['email' => $email, 'password' => $password] = $request->validated();

        return new static(
            $email,
            $password,
            $request->headers->get('x-device-id'),
        );
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
