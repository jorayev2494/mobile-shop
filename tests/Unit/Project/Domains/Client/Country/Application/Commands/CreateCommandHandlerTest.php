<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Client\Country\Application\Commands;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Country\Application\Commands\Create\Command;
use Project\Domains\Admin\Country\Domain\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Application\Commands\Create\CommandHandler;
use Project\Domains\Admin\Country\Domain\Country;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryISO;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUuid;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryValue;

class CreateCommandHandlerTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testCountryCreate(): void
    {
        $uuid = $this->faker->uuid();
        $value = $this->faker->slug();
        $iso = 'tk';
        $isActive = $this->faker->boolean();

        $command = new Command($uuid, $value, $iso, $isActive);

        $countryUuid = CountryUuid::fromValue($uuid);
        $countryValue = CountryValue::fromValue($value);
        $countryISO = CountryISO::fromValue($iso);

        $country = Country::create(
            $countryUuid,
            $countryValue,
            $countryISO,
            $isActive,
        );

        $commandHandler = new CommandHandler(
            $repository = $this->createMock(CountryRepositoryInterface::class)
        );

        $repository->expects(self::once())
                    ->method('save')
                    ->with($country);

        $commandHandler($command);
    }
}
