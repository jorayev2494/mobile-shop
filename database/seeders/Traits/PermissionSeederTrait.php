<?php

declare(strict_types=1);

namespace Database\Seeders\Traits;

use App\Models\Role;
use Project\Domains\Admin\Role\Application\Commands\CreatePermission\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

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
        $subject = class_basename(strtolower($model));

        $actions = array_map(static fn (string $action): array => compact('action'), $actions);
        $subjectPermissionActions = array_merge($this->defaultModelPermissionActions, $actions);

        /** @var Role $adminRole */
        // $adminRole = Role::first();
        // $adminRole->permissions()->createMany(
        //     array_map(
        //         static fn (array $permission): array => [
        //             'value' => "{$subject}_{$permission['action']}",
        //             'subject' => $subject,
        //             'action' => $permission['action'],
        //         ],
        //         $subjectPermissionActions
        //     )
        // );
        
        $commandBus = app()->make(CommandBusInterface::class);
        foreach ($subjectPermissionActions as ['action' => $action]) {
            $commandBus->dispatch(new Command($subject, $action));
        }
    }
}
