<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Services\AuthenticateService;

class AuthenticationCredentialsDTO
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
