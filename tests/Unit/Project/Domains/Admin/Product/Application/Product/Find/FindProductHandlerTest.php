<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Product\Find;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Application\Queries\Find\Query;
use Project\Domains\Admin\Product\Application\Queries\Find\QueryHandler;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Domain\DomainException;
use Tests\Unit\Project\Domains\Admin\Product\Application\Product\ProductFactory;

class FindProductHandlerTest extends TestCase
{
    public function testFind(): void
    {
        $handler = new QueryHandler(
            $productRepository = $this->createMock(ProductRepositoryInterface::class),
        );

        $productRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(ProductUuid::fromValue(ProductFactory::UUID))
                        ->willReturn($product = ProductFactory::make());

        $result = $handler(new Query(ProductFactory::UUID));

        $this->assertEquals($result->getUuid()->value, ProductFactory::UUID);
        $this->assertTrue($result->getUuid()->isEquals($product->getUuid()));
        $this->assertTrue($result->getTitle()->isEquals($product->getTitle()));
        $this->assertTrue($result->getCategory()->getUuid()->isEquals($product->getCategory()->getUuid()));

        $this->assertSame($result->getPrice()->toArray(), $product->getPrice()->toArray());

        $this->assertSame($result->getMedias(), $product->getMedias());
        $this->assertSame($result->getMedias(), $product->getMedias());

        $this->assertTrue($result->getDescription()->isEquals($product->getDescription()));
        $this->assertSame($result->getViewedCount(), $product->getViewedCount());
    }

    public function testNotFound(): void
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Product not found');
        $this->expectExceptionCode(404);

        $handler = new QueryHandler(
            $productRepository = $this->createMock(ProductRepositoryInterface::class),
        );

        $productRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(ProductUuid::fromValue(ProductFactory::UUID))
                        ->willReturn(null);

        $handler(new Query(ProductFactory::UUID));
    }
}
