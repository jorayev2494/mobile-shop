<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Infrastructure\Eloquent;

use App\Models\Role as RoleModel;
use App\Repositories\Base\BaseModelRepository;
use Project\Domains\Admin\Role\Domain\Role;
use Project\Domains\Admin\Role\Domain\RoleRepositoryInterface;
use Project\Domains\Admin\Role\Domain\ValueObjects\RoleId;

class RoleRepository extends BaseModelRepository implements RoleRepositoryInterface
{
    public function getModel(): string
    {
        return RoleModel::class;
    }

    public function findById(RoleId $id): ?Role
    {
        /** @var RoleModel $fRole */
        $fRole = $this->getModelClone()->newQuery()->with('permissions:id,value,model,action,is_active')->find($id->value);

        if ($fRole === null) {
            return null;
        }

        $role = Role::fromPrimitives($fRole->id, $fRole->value, $fRole->permissions->toArray(), $fRole->is_active);

        return $role;
    }

    public function save(Role $role): bool
    {
        /** @var RoleModel $roleModel */
        $roleModel = $this->getModelClone()->newQuery()->updateOrCreate(
            [
                'id' => $role->id->value,
            ],
            $role->toArray()
        );

        $roleModel->permissions()->sync($role->permissions, true);

        return (bool) $role;
    }

    public function delete(RoleId $id): bool
    {
        return $this->getModelClone()->newQuery()->findOrFail($id->value)->delete();
    }

}
