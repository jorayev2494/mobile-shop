<?php

declare(strict_types=1);

namespace App\Services\Api\Auth;

use App\Data\Auth\AuthCredentialsData;
use App\Data\Auth\RefreshTokenData;
use App\Data\Auth\RegisterData;
use App\Models\Admin;
use App\Models\Auth\AppAuth;
use App\Models\Auth\AuthModel;
use App\Models\Device;
use App\Models\Enums\AppGuardType;
use App\Repositories\DeviceRepository;
use App\Services\Api\Contracts\AuthService as ContractsAuthService;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AuthService implements ContractsAuthService
{

    private readonly AuthModel $authModel;

    public function __construct(
        private readonly AppGuardType $guard,
    ) {
        $this->authModel = $this->authModelFactory();
    }

    private function authModelFactory(): AuthModel
    {
        return resolve(auth()->guard($this->guard->value)->getProvider()->getModel());
    }

    public function register(RegisterData $registerData, AppGuardType $guard = AppGuardType::ADMIN): void
    {
        $data = [];

        if ($guard === AppGuardType::ADMIN) {
            $data = ['role_id' => 1,];
            $data = $registerData->toArray() + $data;
        } else if ($guard === AppGuardType::CLIENT) {
            $data = $registerData->toArray();
        }

        $this->authModel::query()->create($data);
    }

    public function login(AuthCredentialsData $credentialsData, AppGuardType $guard = AppGuardType::ADMIN): array
    {
        /** @var string|bool $token */
        if (! ($token = Auth::guard($this->guard->value)->attempt($credentialsData->except('device_id')->toArray()))) {
            throw new BadRequestException('Invalid credentials!');
        }

        return $this->authToken(
            $token,
            $authModel = AppAuth::model(),
            $authModel->addDevice($credentialsData->device_id)
        );
    }

    public function refreshToken(RefreshTokenData $data, AppGuardType $guard = AppGuardType::ADMIN): array
    {
        /** @var Device $device */
        $device = app()->call(DeviceRepository::class.'@refreshToken', ['deviceId' => $data->device_id, 'refreshToken' => $data->refresh_token]);

        /** @var string $token */
        if (! $token = auth()->guard($guard->value)->login($device->deviceAble)) {
            throw new BadRequestException('Unauthorized', 401);
        }

        return $this->authToken($token, $device->deviceAble, $device);
    }

    public function logout(?AuthModel $authModel, string $deviceId, AppGuardType $guard = AppGuardType::ADMIN): void
    {
        if (is_null($authModel)) {
            return;
        }

        $authModel->removeDevice($deviceId);
        AppAuth::logout();
    }

    private function authToken(string $token, AuthModel $authModel, Device $device): array
    {
        return [
            'access_token' => $token,
            'refresh_token' => $device->refresh_token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'auth_data' => $authModel,
        ];
    }
}
