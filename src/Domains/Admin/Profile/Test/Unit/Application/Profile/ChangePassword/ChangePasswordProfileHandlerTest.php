<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Test\Unit\Application\Profile\ChangePassword;

use App\Models\Admin;
use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Profile\Application\Commands\ChangePassword\Command;
use Project\Domains\Admin\Profile\Application\Commands\ChangePassword\CommandHandler;
use Project\Shared\Domain\PasswordHasherInterface;
use Project\Shared\Infrastructure\PasswordHasher;
use Project\Domains\Admin\Profile\Test\Unit\Application\ProfileFactory;

class ChangePasswordProfileHandlerTest extends TestCase
{

    public function testChangePassword(): void
    {
        $this->markTestSkipped();
        $passwordHasher = new PasswordHasher();
        $handler = new CommandHandler(
            $passwordHasher = $this->createMock(PasswordHasherInterface::class),
        );

        $adminStub = $this->createStub(Admin::class);
        $adminStub->expects($this->once())
                ->method('password');

        $passwordHasher->expects($this->once())
                    ->method('check')
                    ->with('12345C', '12345C')
                    ->willReturn(true);

        $handler(
            new Command(
                ProfileFactory::UUID,
                '12345C',
                '12345N'
            )
        );
    }
}
