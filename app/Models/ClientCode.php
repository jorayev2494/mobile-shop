<?php

declare(strict_types=1);

namespace App\Models;

final class ClientCode extends Code
{
    protected $connection = 'client_pgsql';

    protected $table = 'auth_members';
}
