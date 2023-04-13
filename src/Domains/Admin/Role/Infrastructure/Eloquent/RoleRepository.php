<?php

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

    public function save(Role $role): bool
    {        
        return (bool) $this->getModelClone()->newQuery()->updateOrCreate(
            [
                'id' => $role->id->value,
            ],
            $role->toArray()
        );
    }

    public function delete(RoleId $id): bool
    {
        return $this->getModelClone()->newQuery()->findOrFail($id->value)->delete();
    }

}
