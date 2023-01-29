<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Base\BaseModelRepository;

final class RoleRepository extends BaseModelRepository
{
    public function getModel(): string
    {
        return Role::class;
    }
}
