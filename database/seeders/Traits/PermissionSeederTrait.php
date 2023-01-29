<?php

declare(strict_types=1);

namespace Database\Seeders\Traits;

use App\Models\Role;

trait PermissionSeederTrait
{
    /**
     * @var array[array-key, array][string, string] $modelPermissionActions
     */
    protected array $modelPermissionActions = [
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

    public function modelPermissionsSeed(string $model, bool $isCreateRole = false): void
    {
        $model = class_basename(strtolower($model));

        if ($isCreateRole) {
            Role::create([
                'value' => $model,
                'prefix' => strtolower($model),
            ]);
        }

        /** @var Role $adminRole */
        $adminRole = Role::first();
        $adminRole->permissions()->createMany(
            array_map(
                static fn (array $permission): array => [
                    'value' => "{$model}_{$permission['action']}",
                    'model' => $model,
                    'action' => $permission['action'],
                ],
                $this->modelPermissionActions
            )
        );
    }
}
