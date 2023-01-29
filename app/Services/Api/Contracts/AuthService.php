<?php

namespace App\Services\Api\Contracts;

use App\Data\Auth\AuthCredentialsData;
use App\Data\Auth\RefreshTokenData;
use App\Data\Auth\RegisterData;
use App\Models\Auth\AuthModel;
use App\Models\Enums\AppGuardType;

interface AuthService
{
    public function register(RegisterData $registerData): void;

    public function login(AuthCredentialsData $credentialsData, AppGuardType $guard = AppGuardType::API): array;

    public function refreshToken(RefreshTokenData $data): array;

    public function logout(?AuthModel $authModel, string $deviceId): void;
}
