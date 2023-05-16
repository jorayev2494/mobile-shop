<?php

declare(strict_types=1);

namespace App\Models\Enums;

use Illuminate\Support\Facades\Auth;

enum AppGuardType: string
{
    case CLIENT = 'client';
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
