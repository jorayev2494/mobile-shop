<?php

declare(strict_types=1);

namespace App\Models\Enums;

enum CodeType: string
{
    case RESTORE_PASSWORD_LINK = 'restore_password_link';
}
