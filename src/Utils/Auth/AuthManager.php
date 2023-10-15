<?php

declare(strict_types=1);

namespace Project\Utils\Auth;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Auth\AuthModel;
use App\Models\Enums\AppGuardType;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class AuthManager implements AuthManagerInterface
{
    public function __construct(
        private readonly \Illuminate\Auth\AuthManager $authManager,
    ) {

    }

    public function auth(AppGuardType $guard = null): ?AuthModel
    {
        return $this->authManager->guard($guard ? $guard->value : AppGuardType::guard())->user();
    }

    public function admin(): ?Admin
    {
        return ($admin = $this->authManager->admin()) instanceof Admin ? $admin : null;
    }

    public function client(): ?Client
    {
        return ($client = $this->authManager->user()) instanceof Client ? $client : null;
    }

    public function uuid(AppGuardType $guard = null): ?string
    {
        $val = $this->authManager->guard($guard ? $guard->value : AppGuardType::guard())->id();

        return ! is_null($val) ? (string) $val : $val;
    }

    public function check(AppGuardType $guard = null): bool
    {
        return $this->authManager->guard($guard ? $guard->value : AppGuardType::guard())->check();
    }

    public function guest(AppGuardType $guard = null): bool
    {
        return $this->authManager->guard($guard ? $guard->value : AppGuardType::guard())->guest();
    }
}
