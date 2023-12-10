<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Test\Unit\Application\Commands\Register;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Authentication\Application\Commands\Register\Command;
use Project\Domains\Client\Authentication\Application\Commands\Register\CommandHandler;
use Project\Domains\Client\Authentication\Domain\Events\MemberWasRegisteredDomainEvent;
use Project\Domains\Client\Authentication\Domain\Member;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;
use Project\Domains\Client\Authentication\Test\Unit\Application\MemberFactory;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\DomainException;
use Project\Shared\Domain\PasswordHasherInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

/**
 * @group client-auth
 * @group client-auth-application
 */
class RegisterClientHandlerTest extends TestCase
{
    public function testClientRegister(): void
    {
        $handler = new CommandHandler(
            $memberRepository = $this->createMock(MemberRepositoryInterface::class),
            $passwordHasher = $this->createMock(PasswordHasherInterface::class),
            $uuidGenerator = $this->createMock(UuidGeneratorInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $uuidGenerator->expects($this->once())
            ->method('generate')
            ->will($this->returnValue($generatedUuid = MemberFactory::UUID));

        $passwordHasher->expects($this->once())
            ->method('hash')
            ->with(MemberFactory::PASSWORD)
            ->will($this->returnValue($hashedPassword = 'hashed-password'));

        $memberRepository->expects($this->once())
            ->method('findByEmail')
            ->with(MemberFactory::EMAIL)
            ->willReturn(null);

        $memberRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Member::class));

        $eventBus->expects($this->once())
            ->method('publish')
            // ->with($this->containsOnlyInstancesOf(MemberWasRegisteredDomainEvent::class))
        ;

        $handler(
            new Command(
                MemberFactory::EMAIL,
                MemberFactory::PASSWORD,
            )
        );
    }

    public function testClientAlreadyExists(): void
    {
        $this->expectException(DomainException::class);
         $this->expectExceptionMessage('Member already exists!');

        $handler = new CommandHandler(
            $memberRepository = $this->createMock(MemberRepositoryInterface::class),
            $passwordHasher = $this->createMock(PasswordHasherInterface::class),
            $uuidGenerator = $this->createMock(UuidGeneratorInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $uuidGenerator->expects($this->never())->method('generate');

        $passwordHasher->expects($this->never())->method('hash');

        $memberRepository->expects($this->once())
            ->method('findByEmail')
            ->with(MemberFactory::EMAIL)
            ->willReturn($member = MemberFactory::make());

        $memberRepository->expects($this->never())
            ->method('save');

        $eventBus->expects($this->never())
            ->method('publish');

        $handler(
            new Command(
                MemberFactory::EMAIL,
                MemberFactory::PASSWORD,
            )
        );
    }
}
