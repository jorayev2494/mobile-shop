<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Project\Domains\Admin\Country\Application\Commands\Create\Command;
use Project\Domains\Admin\Country\Domain\CountryRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class CountrySeeder extends Seeder
{
    private array $countries = [
        [
            'value' => 'united_states',
            'iso' => 'us',
        ],
        [
            'value' => 'turkmenistan',
            'iso' => 'tm',
        ],
        [
            'value' => 'ukraine',
            'iso' => 'ua',
        ],
        [
            'value' => 'russia',
            'iso' => 'ru',
        ],
        [
            'value' => 'poland',
            'iso' => 'pl',
        ],
        [
            'value' => 'turkey',
            'iso' => 'tr',
        ],
    ];

    public function __construct(
        private readonly CountryRepositoryInterface $repository,
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator,
    )
    {

    }

    public function run(): void
    {
        foreach ($this->countries as $key => ['value' => $value, 'iso' => $iso]) {
            $this->commandBus->dispatch(
                new Command(
                    $this->uuidGenerator->generate(),
                    $value,
                    $iso,
                    true,
                )
            );   
        }
    }
}
