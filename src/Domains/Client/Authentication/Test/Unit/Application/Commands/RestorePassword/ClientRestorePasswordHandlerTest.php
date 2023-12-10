<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Test\Unit\Application\Commands\RestorePassword;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Authentication\Application\Commands\RestorePassword\Command;
use Project\Domains\Client\Authentication\Application\Commands\RestorePassword\CommandHandler;
use Project\Domains\Client\Authentication\Domain\Code\Code;
use Project\Domains\Client\Authentication\Domain\Code\CodeRepositoryInterface;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Domains\Client\Authentication\Test\Unit\Application\CodeFactory;
use Project\Domains\Client\Authentication\Test\Unit\Application\MemberFactory;
use Project\Shared\Domain\PasswordHasherInterface;

/**
 * @group client-auth
 * @group client-auth-application
 */
class ClientRestorePasswordHandlerTest extends TestCase
{
    public function testRestorePassword(): void
    {
        $handler = new CommandHandler(
            $memberRepository = $this->createMock(MemberRepositoryInterface::class),
            $codeRepository = $this->createMock(CodeRepositoryInterface::class),
            $passwordHasher = $this->createMock(PasswordHasherInterface::class),
        );

        $passwordHasher->expects($this->once())
            ->method('hash')
            ->will($this->returnValue($hashedPassword = 'hashed-password-value'));

        $code = $this->createMock(Code::class);

        $code->expects($this->once())
            ->method('getAuthor')
            ->will($this->returnValue($member = MemberFactory::make()));

        $codeRepository->expects($this->once())
            ->method('findByCode')
            ->with(CodeFactory::CODE)
            ->will($this->returnValue($code));

        $memberRepository->expects($this->once())
            ->method('save')
            ->with($member);

        $codeRepository->expects($this->once())
            ->method('delete')
            ->with($code);

        $handler(
            new Command(
                CodeFactory::CODE,
                MemberFactory::PASSWORD,
            )
        );
    }
}
