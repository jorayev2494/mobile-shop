<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\Base\BaseModelRepository;
use App\Repositories\Contracts\RoleRepositoryInterface;

final class RoleRepository extends BaseModelRepository implements RoleRepositoryInterface
{
    public function getModel(): string
    {
        return Role::class;
    }
}
