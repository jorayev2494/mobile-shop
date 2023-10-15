<?php

declare(strict_types=1);

namespace Project\Utils\Auth;

use Illuminate\Support\Facades\Auth;

enum AppGuard : string
{
    case CLIENT = 'api';
    case ADMIN = 'admin';

    public static function guard(): ?string
    {
        return match (true) {
            Auth::guard(static::CLIENT->value)->check() => static::CLIENT->value,
            Auth::guard(static::ADMIN->value)->check() => static::ADMIN->value,
            default => null
        };
    }
}
