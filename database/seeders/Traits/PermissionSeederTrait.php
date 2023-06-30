<?php

declare(strict_types=1);

namespace Database\Seeders\Traits;

use App\Models\Role;

trait PermissionSeederTrait
{
    /**
     * @var array[array-key, array][string, string] $defaultModelPermissionActions
     */
    protected array $defaultModelPermissionActions = [
        [
            'action' => 'index',
        ],
        [
            'action' => 'create',
        ],
        [
            'action' => 'show',
        ],
        [
            'action' => 'edit',
        ],
        [
            'action' => 'delete',
        ],
    ];

    public function modelPermissionsSeed(string $model, array $actions = []): void
    {
        $model = class_basename(strtolower($model));

        $actions = array_map(static fn (string $action): array => compact('action'), $actions);
        $modelPermissionActions = array_merge($this->defaultModelPermissionActions, $actions);

        /** @var Role $adminRole */
        $adminRole = Role::first();
        $adminRole->permissions()->createMany(
            array_map(
                static fn (array $permission): array => [
                    'value' => "{$model}_{$permission['action']}",
                    'model' => $model,
                    'action' => $permission['action'],
                ],
                $modelPermissionActions
            )
        );
    }
}
