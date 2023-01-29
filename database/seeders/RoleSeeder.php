<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\Traits\PermissionSeederTrait;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    use PermissionSeederTrait;

    private array $defaultRoles = [
        'admin',
        'moderator',
    ];

    public function run(): void
    {
        Role::factory()->createMany(
            array_map(
                static fn (string $value): array => compact('value'),
                $this->defaultRoles
            )
        );

        $this->modelPermissionsSeed(Admin::class);
        $this->modelPermissionsSeed(User::class);
    }
}
