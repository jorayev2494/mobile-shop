<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Manager\Application\Manager\Show;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Manager\Application\Queries\Show\Query;
use Project\Domains\Admin\Manager\Application\Queries\Show\QueryHandler;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Shared\Domain\DomainException;
use Tests\Unit\Project\Domains\Admin\Manager\Application\Manager\ManagerFactory;

/**
 * @group manager
 * @group manager-application
 */
class ShowManagerHandlerTest extends TestCase
{
    public function testShowManager(): void
    {
        $handler = new QueryHandler(
            $managerRepository = $this->createMock(ManagerRepositoryInterface::class),
        );

        $managerRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(ManagerUuid::fromValue(ManagerFactory::UUID))
                        ->willReturn($manager = ManagerFactory::make());

        $handler(new Query(ManagerFactory::UUID));
    }

    public function testNotFound(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Manager not found');
        $this->expectExceptionCode(404);

        $handler = new QueryHandler(
            $managerRepository = $this->createMock(ManagerRepositoryInterface::class),
        );

        $managerRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(ManagerUuid::fromValue(ManagerFactory::UUID))
                        ->willReturn(null);

        $handler(new Query(ManagerFactory::UUID));
    }
}
