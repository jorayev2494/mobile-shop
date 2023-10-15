<?php

declare(strict_types=1);

namespace Project\Infrastructure\Services\Authenticate;

use App\Models\Enums\AppGuardType;
use Project\Shared\Infrastructure\Services\AuthenticateService\AuthenticationCredentialsDTO;

interface AuthenticationServiceInterface
{
    public function authenticate(AuthenticationCredentialsDTO $data, AppGuardType $guard, array $claims = []): string;

    public function authenticateByUuid(string $uuid, AppGuardType $guard, array $claims = []): string;

    public function invalidate(AppGuardType $guard): void;

    public function logout(AppGuardType $guard): void;

    public function authToken(string $token, AuthenticatableInterface $authData, DeviceInterface $device): array;
}
