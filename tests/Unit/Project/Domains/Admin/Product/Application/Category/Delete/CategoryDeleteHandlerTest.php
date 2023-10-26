<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Application\Category\Delete;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Application\Commands\Categories\Delete\Command;
use Project\Domains\Admin\Product\Application\Commands\Categories\Delete\CommandHandler;
use Project\Domains\Admin\Product\Domain\Category\Category;
use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\DomainException;
use Tests\Unit\Project\Domains\Admin\Product\Application\Category\CategoryFactory;

class CategoryDeleteHandlerTest extends TestCase
{
    public function testDeleteCategory(): void
    {
        $handler = new CommandHandler(
            $categoryRepository = $this->createMock(CategoryRepositoryInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $categoryStub = $this->createStub(Category::class);

        $categoryStub->expects($this->once())
            ->method('delete');

        $categoryStub->expects($this->never())
            ->method('record');

        $categoryStub->expects($this->once())
                    ->method('pullDomainEvents');

        $categoryRepository->expects($this->once())
                    ->method('findByUuid')
                    ->with(Uuid::fromValue(CategoryFactory::UUID))
                    ->willReturn($categoryStub);

        $categoryRepository->expects($this->once())
                    ->method('delete')
                    ->with($categoryStub);

        $eventBus->expects($this->once())
                    ->method('publish');

        $handler(new Command(CategoryFactory::UUID));
    }

    public function testNotFound(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Category not found');
        $this->expectExceptionCode(404);

        $handler = new CommandHandler(
            $categoryRepository = $this->createMock(CategoryRepositoryInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $categoryRepository->expects($this->once())
                    ->method('findByUuid')
                    ->with(Uuid::fromValue(CategoryFactory::UUID))
                    ->willReturn(null);
        
        $categoryRepository->expects($this->never())
                    ->method('delete');

        $eventBus->expects($this->never())
                    ->method('publish');

        $handler(new Command(CategoryFactory::UUID));
    }
}
