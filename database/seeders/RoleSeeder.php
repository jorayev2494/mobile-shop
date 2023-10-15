<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\Traits\PermissionSeederTrait;
use Illuminate\Database\Seeder;
use Project\Domains\Admin\Role\Application\Commands\Create\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class RoleSeeder extends Seeder
{
    use PermissionSeederTrait;

    private array $defaultRoles = [
        'admin',
        'moderator',
    ];

    public function __construct(
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function run(): void
    {
        // Role::factory()->createMany(
        //     array_map(
        //         static fn (string $value): array => compact('value'),
        //         $this->defaultRoles
        //     )
        // );

        foreach ($this->defaultRoles as $key => $value) {
            $this->commandBus->dispatch(
                new Command($value, [])
            );
        }

        $this->modelPermissionsSeed(Admin::class, ['block']);
        $this->modelPermissionsSeed(User::class, ['block']);
        $this->modelPermissionsSeed(Country::class);
        $this->modelPermissionsSeed(Product::class);
        $this->modelPermissionsSeed(Category::class);
        $this->modelPermissionsSeed(Order::class);
    }
}
