<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Permission\Infrastructure\Eloquent;

use App\Models\Permission as ModelPermission;
use App\Repositories\Base\BaseModelRepository;
use Project\Domains\Admin\Permission\Domain\PermissionRepositoryInterface;

final class PermissionRepository extends BaseModelRepository implements PermissionRepositoryInterface
{
    public function getModel(): string
    {
        return ModelPermission::class;
    }
}
