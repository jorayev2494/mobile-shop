<?php

declare(strict_types=1);

namespace Project\Utils\Auth;

use App\Models\Admin;
use App\Models\Auth\AuthModel;
use App\Models\Client;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class AuthManager implements AuthManagerInterface
{

    public function __construct(
        private readonly \Illuminate\Auth\AuthManager $authManager,
    )
    {

    }

    // public function guard(?string $name = null) : \Illuminate\Contracts\Auth\StatefulGuard
    // {

    // }

    public function auth(AuthGuard $guard = null): ?AuthModel
    {
        return $this->authManager->guard($guard ? $guard->value : AuthGuard::guard())->user();
    }

    public function admin(): ?Admin
    {
        return ($admin = $this->authManager->admin()) instanceof Admin ? $admin : null;
    }

    public function client(): ?Client
    {
        return ($client = $this->authManager->user()) instanceof Client ? $client : null;
    }

    public function check(AuthGuard $guard = null): bool
    {
        return $this->authManager->guard($guard ? $guard->value : AuthGuard::guard())->check();
    }

    public function guest(AuthGuard $guard = null): bool
    {
        return $this->authManager->guard($guard ? $guard->value : AuthGuard::guard())->guest();
    }
}
