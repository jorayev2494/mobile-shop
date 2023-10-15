<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Client\Authentication\Application\Commands\Login;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Authentication\Application\Commands\Login\Command;

class CommandTest extends \PHPUnit\Framework\TestCase
{

    private Generator $faker;

    public function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testCommand(): void
    {
        $email = $this->faker->email();
        $password = $this->faker->password();
        $deviceId = $this->faker->uuid();

        $command = new Command($email, $password, $deviceId);

        $this->assertSame($email, $command->email);
        $this->assertSame($password, $command->password);
        $this->assertSame($deviceId, $command->deviceId);
    }
}
