<?php

declare(strict_types=1);

namespace App\Models\Enums;

use Illuminate\Support\Facades\Auth;

enum AppGuardType: string
{
    case API = 'api';
    case ADMIN = 'admin';

    public static function guard(): ?string
    {
        return match (true) {
            Auth::guard(static::API->value)->check() => static::API->value,
            Auth::guard(static::ADMIN->value)->check() => static::ADMIN->value,
            default => null
        };
    }
}
