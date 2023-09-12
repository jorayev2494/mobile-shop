<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Client\Authentication\Application\Commands\Login;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Authentication\Application\Commands\Login\Command;
use Project\Domains\Admin\Authentication\Application\Commands\Login\CommandHandler;
use Project\Domains\Admin\Authentication\Domain\Device\DeviceRepositoryInterface;
use Project\Domains\Admin\Authentication\Infrastructure\Doctrine\MemberRepository;

class CommandHandlerTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        $this->faker = Factory::create();
    }

    public function testCommandHandler(): void
    {
        $email = $this->faker->email();
        $password = $this->faker->password();
        $deviceId = $this->faker->uuid();

        $command = new Command($email, $password, $deviceId);

        // $memberRepository = $this->createMock(MemberRepository::class)
                                            // ->expects(self::once())
                                            // ->method('findByEmail')
                                            // ->with($email);

        // $deviceRepository = $this->createMock(DeviceRepositoryInterface::class)
        //                                     ->expects(self::once())
        //                                     ->method()

        // $handler = new CommandHandler(
        //     $memberRepository,
        // );


        $this->assertSame($email, $command->email);
        $this->assertSame($password, $command->password);
        $this->assertSame($deviceId, $command->deviceId);
    }
}
