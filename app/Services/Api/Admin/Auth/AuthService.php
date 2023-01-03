<?php

declare(strict_types=1);

namespace App\Services\Api\Admin\Auth;

class AuthService
{
    public function login(array $credentials): array
    {
        return [
            'method' => __METHOD__,
            'credentials' => $credentials,
        ];
    }
}
