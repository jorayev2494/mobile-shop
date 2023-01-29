<?php

declare(strict_types=1);

namespace App\Models\Auth;

use App\Models\Admin;
use App\Models\Enums\AppGuardType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AppAuth
{
    public static function model(AppGuardType $guard = null): ?AuthModel
    {
        return Auth::guard($guard ? $guard->value : AppGuardType::guard())->user();
    }

    public static function admin(): ?Admin
    {
        return Auth::admin();
    }

    public static function user(): ?User
    {
        return Auth::user();
    }

    public static function check(AppGuardType $guard = null): bool
    {
        return Auth::guard($guard ? $guard->value : AppGuardType::guard())->check();
    }

    public static function guest(AppGuardType $guard = null): bool
    {
        return Auth::guard($guard ? $guard->value : AppGuardType::guard())->guest();
    }

    public static function id(): ?int
    {
        return Auth::guard(AppGuardType::guard())->id();
    }

    public static function logout(AppGuardType $guard = null): void
    {
        Auth::guard($guard ? $guard->value : AppGuardType::guard())->logout();
    }
}
