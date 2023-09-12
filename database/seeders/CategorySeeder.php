<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Project\Domains\Admin\Category\Application\Commands\Create\CreateCategoryCommand;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;
use Ramsey\Uuid\Uuid;

class CategorySeeder extends Seeder
{
    private array $categories = [
        'chair',
        'table',
        'armchair',
        'bed',
        'sofa',
    ];

    public function __construct(
        private readonly UuidGeneratorInterface $uuidGEnerator,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function run(): void
    {
        foreach ($this->categories as $value) {
            $this->commandBus->dispatch(
                new CreateCategoryCommand(
                    $this->uuidGEnerator->generate(),
                    $value,
                    true,
                )
            );
        }
    }
}
