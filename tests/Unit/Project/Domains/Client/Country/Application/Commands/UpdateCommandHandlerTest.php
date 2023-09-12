<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Client\Country\Application\Commands;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Country\Application\Commands\Create\CommandHandler as CreateCommandHandler;
use Project\Domains\Admin\Country\Application\Commands\Update\Command;
use Project\Domains\Admin\Country\Application\Commands\Update\CommandHandler;
use Project\Domains\Admin\Country\Domain\Country;
use Project\Domains\Admin\Country\Domain\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryISO;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUuid;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryValue;

class UpdateCommandHandlerTest extends TestCase
{

    private Generator $faker;
    private CreateCommandHandler $createCommandHandler;

    public function setUp(): void
    {
        $this->faker = Factory::create('ru_RU');
        $this->createCommandHandler = app()->make(CreateCommandHandler::class);
    }

    public function testCountryUpdate(): void
    {
        $uuid = $this->faker->uuid();
        $value = $this->faker->slug(1);
        $iso = 'tk';
        $isActive = $this->faker->boolean();

        $createCommand = new \Project\Domains\Admin\Country\Application\Commands\Create\Command($uuid, $value, $iso, $isActive);
        $this->createCommandHandler($createCommand);


        $value .= '-updated';
        $iso = 'uz';
        $command = new Command($uuid, $value, $iso, $isActive);
        $repository = $this->createMock(CountryRepositoryInterface::class);

        $country = Country::create(
            CountryUuid::fromValue($uuid),
            CountryValue::fromValue($value),
            CountryISO::fromValue($iso),
            $isActive,
        );

        $repository->expects(self::once())
                    ->method('findByUuid')
                    ->with(CountryUuid::fromValue($uuid))
                    ->willReturn($country);

        $country->setValue($value);
        $country->setISO($iso);
        $country->setIsActive(!$isActive);

        $repository->expects(self::once())
                    ->method('save')
                    ->with($country);

        $commandHandler = new CommandHandler($repository);
        $commandHandler($command);
    }
}
