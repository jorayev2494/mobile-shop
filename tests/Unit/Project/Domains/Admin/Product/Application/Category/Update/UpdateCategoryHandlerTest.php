<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Application\Category\Update;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Application\Commands\Categories\Update\Command;
use Project\Domains\Admin\Product\Application\Commands\Categories\Update\CommandHandler;
use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid;
use Project\Shared\Domain\DomainException;
use Tests\Unit\Project\Domains\Admin\Product\Application\Category\CategoryFactory;

/**
 * @group category
 * @group category-application
 */
class UpdateCategoryHandlerTest extends TestCase
{
    public function testUpdateCategory(): void
    {
        $handler = new CommandHandler(
            $categoryRepository = $this->createMock(CategoryRepositoryInterface::class),
        );

        $categoryRepository->expects($this->once())
                            ->method('findByUuid')
                            ->with(CategoryFactory::UUID)
                            ->willReturn($category = CategoryFactory::make());

        $categoryRepository->expects($this->once())
                            ->method('save')
                            // ->with($category = CategoryFactory::make(category: 'Sofa', isActive: true))
                            ;

        $handler(
            new Command(
                CategoryFactory::UUID,
                'Sofa',
                true,
            )
        );
    }



    public function testNotFound(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Category not found');
        $this->expectExceptionCode(404);

        $handler = new CommandHandler(
            $categoryRepository = $this->createMock(CategoryRepositoryInterface::class),
        );

        $categoryRepository->expects($this->once())
                    ->method('findByUuid')
                    ->with(Uuid::fromValue(CategoryFactory::UUID))
                    ->willReturn(null);
        
        $categoryRepository->expects($this->never())
                    ->method('save');

        $handler(
            new Command(
                CategoryFactory::UUID,
                'Sofa',
                true
            )
        );
    }
}
