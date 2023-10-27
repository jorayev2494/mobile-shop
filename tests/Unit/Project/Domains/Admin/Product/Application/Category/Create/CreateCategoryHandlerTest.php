<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Application\Category\Create;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Application\Commands\Categories\Create\Command;
use Project\Domains\Admin\Product\Application\Commands\Categories\Create\CommandHandler;
use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Category\Events\CategoryWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Tests\Unit\Project\Domains\Admin\Product\Application\Category\CategoryFactory;

/**
 * @group category
 * @group category-application
 */
class CreateCategoryHandlerTest extends TestCase
{
    public function testCreateCategory(): void
    {
        $handler = new CommandHandler(
            $categoryRepository = $this->createMock(CategoryRepositoryInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $categoryRepository->expects($this->once())
                        ->method('save');

        $eventBus->expects($this->once())
                ->method('publish')
                // ->with($this->isInstanceOf(CategoryWasCreatedDomainEvent::class));
                ->with(
                    new CategoryWasCreatedDomainEvent(
                        CategoryFactory::UUID,
                        CategoryFactory::CATEGORY,
                        CategoryFactory::IS_ACTIVE,
                    )
                );
    
        $handler(
            new Command(
                CategoryFactory::UUID,
                CategoryFactory::CATEGORY,
                CategoryFactory::IS_ACTIVE,
            )
        );
    }
}
