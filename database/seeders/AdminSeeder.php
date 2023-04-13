<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    private array $adminEmails = [
        'admin@gmail.com',
        'admin2@gmail.com',
    ];

    public function run(): void
    {
        $role = Role::query()->first();

        Admin::factory()->createMany(
            array_map(
                static fn (string $email): array => compact('email') + ['role_id' => $role->id],
                $this->adminEmails,
            )
        );
    }
}
