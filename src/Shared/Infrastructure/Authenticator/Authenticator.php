<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Authenticator;

use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use Illuminate\Http\Response;
use Project\Shared\Domain\Authenticator\AuthenticatableInterface;
use Project\Shared\Domain\Authenticator\AuthenticatorInterface;
use Project\Shared\Domain\Authenticator\DeviceInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

final class Authenticator implements AuthenticatorInterface
{

    public function login(AuthenticateCredentialDTO $data, AppGuardType $guard, array $claims = []): string
    {
        /** @var string $token */
        if (! ($token = \Auth::guard($guard->value)->claims($claims)->attempt($data->toArray()))) {
            throw new BadRequestException('Invalid credentials!');
        }

        return $token;
    }

    public function loginByUuid(string $uuid, AppGuardType $guard, array $claims = []): string
    {
        /** @var string $token */
        if (! ($token = \Auth::guard($guard->value)->claims($claims)->tokenById($uuid))) {
            throw new BadRequestException('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        return $token;
    }

    public function invalidate(AppGuardType $guard): void
    {
        \Auth::guard($guard->value)->invalidate(true);
    }

    public function logout(AppGuardType $guard): void
    {
        AppAuth::logout($guard);
    }

    public function authToken(string $token, AuthenticatableInterface $authData, DeviceInterface $device): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'refresh_token' => $device->getRefreshToken(),
            'expires_in' => auth()->factory()->getTTL() * 60,
            'auth_data' => $authData->toArray(),
        ];
    }
}
