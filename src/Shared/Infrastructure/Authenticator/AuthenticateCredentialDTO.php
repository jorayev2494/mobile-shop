<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Authenticator;

class AuthenticateCredentialDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    )
    {
        
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
