<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Authenticator;

use App\Models\Enums\AppGuardType;
use Project\Shared\Infrastructure\Authenticator\AuthenticateCredentialDTO;

interface AuthenticatorInterface
{
    public function login(AuthenticateCredentialDTO $data, AppGuardType $guard, array $claims = []): string;
    public function loginByUuid(string $uuid, AppGuardType $guard, array $claims = []): string;
    public function invalidate(AppGuardType $guard): void;
    public function logout(AppGuardType $guard): void;
    public function authToken(string $token, AuthenticatableInterface $authData, DeviceInterface $device): array;
}
