<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Project\Domains\Admin\Product\Application\Commands\Currencies\Create\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class CurrencySeeder extends Seeder
{
    private array $currencies = [
        'USD',
        'TMT',
        'UAH',
        'RUB',
        'PLN',
        'TRY',
    ];

    public function __construct(
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly CommandBusInterface $commandBus,
    )
    {

    }

    public function run(): void
    {
        foreach ($this->currencies as $value) {
            $this->commandBus->dispatch(
                new Command(
                    $this->uuidGenerator->generate(),
                    $value,
                    true,
                )
            );
        }
    }
}
