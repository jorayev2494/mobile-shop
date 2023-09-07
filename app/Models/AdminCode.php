<?php

declare(strict_types=1);

namespace App\Models;

final class AdminCode extends Code
{
    protected $connection = 'admin_pgsql';

    protected $table = 'auth_codes';
}
