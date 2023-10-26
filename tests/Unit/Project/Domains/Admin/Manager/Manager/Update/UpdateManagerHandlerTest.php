<?php

declare(strict_types= 1);

namespace Tests\Unit\Project\Domains\Admin\Manager\Manager\Update;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Manager\Application\Commands\Update\Command;
use Project\Domains\Admin\Manager\Application\Commands\Update\CommandHandler;
use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerEmail;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerFirstName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerLastName;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerPhone;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\DomainException;
use Tests\Unit\Project\Domains\Admin\Manager\Manager\ManagerFactory;

class UpdateManagerHandlerTest extends TestCase
{
    public function testUpdateManager(): void
    {
        $handler = new CommandHandler(
            $managerRepository = $this->createMock(ManagerRepositoryInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class)
        );

        $managerStub = $this->createStub(Manager::class);

        $managerStub->expects($this->once())->method('changeFirstName')->with(ManagerFirstName::fromValue('Tom'));
        $managerStub->expects($this->once())->method('changeLastName')->with(ManagerLastName::fromValue('Tomov'));;
        $managerStub->expects($this->once())->method('changeEmail')->with(ManagerEmail::fromValue('tom@gmail.com'));;
        $managerStub->expects($this->once())->method('changePhone')->with(ManagerPhone::fromValue('1234'));;
        $managerStub->expects($this->once())->method('changeRoleId')->with(2);

        // $managerStub->expects($this->once())->method('record');
        $managerStub->expects($this->once())->method('pullDomainEvents');

        $managerRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(ManagerUuid::fromValue(ManagerFactory::UUID))
                        ->willReturn($managerStub);

        $managerRepository->expects($this->once())
                        ->method('save')
                        ->with($managerStub)
                        ;

        $eventBus->expects($this->once())->method('publish');

        $handler(
            new Command(
                ManagerFactory::UUID,
                'Tom',
                'Tomov',
                'tom@gmail.com',
                '1234',
                2
            )
        );
    }

    public function testNotFound(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Manager not found');
        $this->expectExceptionCode(404);

        $handler = new CommandHandler(
            $managerRepository = $this->createMock(ManagerRepositoryInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class)
        );

        $managerStub = $this->createStub(Manager::class);

        $managerStub->expects($this->never())->method('changeFirstName')->with(ManagerFirstName::fromValue('Tom'));
        $managerStub->expects($this->never())->method('changeLastName')->with(ManagerLastName::fromValue('Tomov'));;
        $managerStub->expects($this->never())->method('changeEmail')->with(ManagerEmail::fromValue('tom@gmail.com'));;
        $managerStub->expects($this->never())->method('changePhone')->with(ManagerPhone::fromValue('1234'));;
        $managerStub->expects($this->never())->method('changeRoleId')->with(2);

        // $managerStub->expects($this->once())->method('record');
        $managerStub->expects($this->never())->method('pullDomainEvents');

        $managerRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(ManagerUuid::fromValue(ManagerFactory::UUID))
                        ->willReturn(null);

        $managerRepository->expects($this->never())
                        ->method('save')
                        ->with($managerStub)
                        ;

        $eventBus->expects($this->never())->method('publish');

        $handler(
            new Command(
                ManagerFactory::UUID,
                'Tom',
                'Tomov',
                'tom@gmail.com',
                '1234',
                2
            )
        );
    }
}
