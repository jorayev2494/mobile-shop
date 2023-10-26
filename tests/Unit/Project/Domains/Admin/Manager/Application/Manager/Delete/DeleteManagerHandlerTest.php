<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Manager\Application\Manager\Delete;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Manager\Application\Commands\Delete\Command;
use Project\Domains\Admin\Manager\Application\Commands\Delete\CommandHandler;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Shared\Domain\DomainException;
use Tests\Unit\Project\Domains\Admin\Manager\Application\Manager\ManagerFactory;

class DeleteManagerHandlerTest extends TestCase
{
    public function testDeleteManager(): void
    {
        $handler = new CommandHandler(
            $managerRepository = $this->createMock(ManagerRepositoryInterface::class),
        );

        $managerRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(ManagerUuid::fromValue(ManagerFactory::UUID))
                        ->willReturn($manager = ManagerFactory::make());

        $managerRepository->expects($this->once())
                        ->method('delete')
                        ->with($manager);

        $handler(new Command(ManagerFactory::UUID));
    }

    public function testNotFound(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Manager not found');
        $this->expectExceptionCode(404);

        $handler = new CommandHandler(
            $managerRepository = $this->createMock(ManagerRepositoryInterface::class),
        );

        $managerRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(ManagerUuid::fromValue(ManagerFactory::UUID))
                        ->willReturn(null);

        $managerRepository->expects($this->never())
                        ->method('delete');

        $handler(new Command(ManagerFactory::UUID));
    }
}
