<?php

namespace App\Services\Api\Contracts;

use App\Data\Auth\AuthCredentialsData;
use App\Data\Auth\RefreshTokenData;
use App\Data\Auth\RegisterData;
use App\Models\Auth\AuthModel;
use App\Models\Enums\AppGuardType;

interface AuthService
{
    public function register(RegisterData $registerData, AppGuardType $guard = AppGuardType::ADMIN): void;

    public function login(AuthCredentialsData $credentialsData, AppGuardType $guard = AppGuardType::ADMIN): array;

    public function refreshToken(RefreshTokenData $data, AppGuardType $guard = AppGuardType::ADMIN): array;

    public function logout(?AuthModel $authModel, string $deviceId, AppGuardType $guard = AppGuardType::ADMIN): void;
}
