<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Project\Domains\Admin\Authentication\Application\Commands\Register\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class AdminSeeder extends Seeder
{
    private array $adminEmails = [
        'admin@gmail.com',
        'admin2@gmail.com',
    ];

    public function __construct(
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function run(): void
    {
        foreach ($this->adminEmails as $key => $email) {
            $this->commandBus->dispatch(
                new Command(
                    "Admin{$key}",
                    "Adminov{$key}",
                    $email,
                    '12345Secret_',
                    true,
                )
            );
        }
    }
}
