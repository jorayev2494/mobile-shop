<?php

namespace Project\Domains\Admin\Role\Domain;

use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleId;

interface RoleRepositoryInterface extends BaseModelRepositoryInterface
{
    public function save(Role $role): bool;
    public function delete(RoleId $id): bool;
}
