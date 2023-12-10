<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Test\Unit\Application\Commands\RestorePasswordCode;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Authentication\Application\Commands\RestorePasswordCode\Command;
use Project\Domains\Client\Authentication\Application\Commands\RestorePasswordCode\CommandHandler;
use Project\Domains\Client\Authentication\Domain\Code\Code;
use Project\Domains\Client\Authentication\Domain\Code\Events\RestorePasswordCodeWasCreatedDomainEvent;
use Project\Domains\Client\Authentication\Domain\Member;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Domains\Client\Authentication\Test\Unit\Application\MemberFactory;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\CodeGeneratorInterface;
use Project\Shared\Domain\DomainException;

/**
 * @group client-auth
 * @group client-auth-application
 */
class ClientRestorePasswordCodeHandlerTest extends TestCase
{
    public function testRestorePasswordCode(): void
    {
        $handler = new CommandHandler(
            $memberRepository = $this->createMock(MemberRepositoryInterface::class),
            $codeGenerator = $this->createMock(CodeGeneratorInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $member = $this->createMock(Member::class);

        $memberRepository->expects($this->once())
            ->method('findByEmail')
            ->with(MemberFactory::EMAIL)
            ->will($this->returnValue($member));

        $codeGenerator->expects($this->once())
            ->method('generate')
            ->will($this->returnValue($generatedCode = 908070));

        $member->expects($this->once())
            ->method('addCode')
            ->with($this->isInstanceOf(Code::class));

        $memberRepository->expects($this->once())
            ->method('save')
            ->with($member);

        $eventBus->expects($this->once())
            ->method('publish');

        $handler(
            new Command(MemberFactory::EMAIL)
        );
    }

    public function testMemberNotFound(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Member not found');
        $this->expectExceptionCode(404);

        $handler = new CommandHandler(
            $memberRepository = $this->createMock(MemberRepositoryInterface::class),
            $codeGenerator = $this->createMock(CodeGeneratorInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $member = $this->createMock(Member::class);

        $memberRepository->expects($this->once())
            ->method('findByEmail')
            ->with(MemberFactory::EMAIL)
            ->willReturn(null);

        $codeGenerator->expects($this->never())
            ->method('generate')
            ->will($this->returnValue($generatedCode = 908070));

        $member->expects($this->never())
            ->method('addCode')
            ->with($this->isInstanceOf(Code::class));

        $memberRepository->expects($this->never())
            ->method('save')
            ->with($member);

        $eventBus->expects($this->never())
            ->method('publish')
            ->with($this->containsOnlyInstancesOf(RestorePasswordCodeWasCreatedDomainEvent::class));

        $handler(
            new Command(MemberFactory::EMAIL)
        );
    }
}
