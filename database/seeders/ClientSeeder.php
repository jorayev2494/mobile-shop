<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Project\Domains\Client\Authentication\Application\Commands\Register\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class ClientSeeder extends Seeder
{
    private array $clientEmails = [
        'client@gmail.com',
        'client2@gmail.com',
    ];

    public function __construct(
        private readonly CommandBusInterface $commandBus,
    )
    {

    }

    public function run(): void
    {
        foreach ($this->clientEmails as $key => $clientEmail) {
            $this->commandBus->dispatch(
                new Command(
                    "Client{$key}",
                    "Clientov{$key}",
                    $clientEmail,
                    '12345Secret_',
                )
            );
        }
    }
}
