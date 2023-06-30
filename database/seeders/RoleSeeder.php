<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use App\Models\Product;
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

        $this->modelPermissionsSeed(Admin::class, ['block']);
        $this->modelPermissionsSeed(User::class, ['block']);
        $this->modelPermissionsSeed(Country::class);
        $this->modelPermissionsSeed(Product::class);
        $this->modelPermissionsSeed(Category::class);
        $this->modelPermissionsSeed(Order::class);
    }
}
