<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Permission\Domain;

use Project\Domains\Admin\Permission\Domain\ValueObjects\PermissionAction;
use Project\Domains\Admin\Permission\Domain\ValueObjects\PermissionId;
use Project\Domains\Admin\Permission\Domain\ValueObjects\PermissionModel;
use Project\Domains\Admin\Permission\Domain\ValueObjects\PermissionValue;

final class Permission
{
    private function __construct(
        public readonly PermissionId $id,
        public readonly PermissionValue $value,
        public readonly PermissionModel $model,
        public readonly PermissionAction $action,
        public readonly bool $isActive = true,
    )
    {
        
    }

    public function fromPrimitives(int $id, string $value, string $model, string $action, bool $isActive = true): self
    {
        return new self(
            PermissionId::fromValue($id),
            PermissionValue::fromValue($value),
            PermissionModel::fromValue($model),
            PermissionAction::fromValue($action),
            $isActive
        );
    }
}
