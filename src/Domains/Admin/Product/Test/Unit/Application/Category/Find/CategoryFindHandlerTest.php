<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Test\Unit\Application\Category\Find;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Application\Queries\Categories\Find\Query;
use Project\Domains\Admin\Product\Application\Queries\Categories\Find\QueryHandler;
use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid;
use Project\Domains\Admin\Product\Test\Unit\Application\Category\CategoryFactory;
use Project\Shared\Domain\DomainException;

/**
 * @group category
 * @group category-application
 */
class CategoryFindHandlerTest extends TestCase
{
    public function testFindCategory(): void
    {
        $handler = new QueryHandler(
            $categoryRepository = $this->createMock(CategoryRepositoryInterface::class),
        );

        $categoryRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(Uuid::fromValue(CategoryFactory::UUID))
                        ->willReturn($category = CategoryFactory::make());

        $handler(new Query(CategoryFactory::UUID));
    }

    public function testNotFound(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Category not found');
        $this->expectExceptionCode(404);

        $handler = new QueryHandler(
            $categoryRepository = $this->createMock(CategoryRepositoryInterface::class),
        );

        $categoryRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(Uuid::fromValue(CategoryFactory::UUID))
                        ->willReturn(null);

        $handler(new Query(CategoryFactory::UUID));
    }
}
