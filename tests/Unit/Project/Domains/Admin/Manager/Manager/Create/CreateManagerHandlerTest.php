<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Manager\Manager\Create;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Manager\Application\Commands\Create\Command;
use Project\Domains\Admin\Manager\Application\Commands\Create\CommandHandler;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Tests\Unit\Project\Domains\Admin\Manager\Manager\ManagerFactory;

class CreateManagerHandlerTest extends TestCase
{
    public function testCreateManager(): void
    {
        $handler = new CommandHandler(
            $managerRepository = $this->createMock(ManagerRepositoryInterface::class),
        );

        $managerRepository->expects($this->once())
                        ->method('save');

        $handler(
            new Command(
                ManagerFactory::UUID,
                ManagerFactory::FIRST_NAME,
                ManagerFactory::LAST_NAME,
                ManagerFactory::EMAIL,
                ManagerFactory::ROLE_ID,
            )
        );
    }
}
