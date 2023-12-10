<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Domain\Product;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Order\Domain\Category\Category;
use Project\Domains\Client\Order\Domain\Product\Product;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Description;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Title;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Uuid;
use Project\Domains\Client\Order\Test\Unit\Application\CategoryFactory;
use Project\Domains\Client\Order\Test\Unit\Application\PriceFactory;
use Project\Domains\Client\Order\Test\Unit\Application\ProductFactory;
use Project\Shared\Domain\Aggregate\AggregateRoot;

/**
 * @group order-domain
 * @group order-product-domain
 */
class ProductTest extends TestCase
{
    public function testFromPrimitives(): void
    {
        $product = Product::fromPrimitives(
            ProductFactory::UUID,
            ProductFactory::TITLE,
            CategoryFactory::make(),
            PriceFactory::make(),
            ProductFactory::DESCRIPTION,
            ProductFactory::VIEWED_COUNT,
            ProductFactory::IS_ACTIVE,
        );

        $this->assertNotNull($product);
        $this->assertInstanceOf(Product::class, $product);
        $this->assertNotInstanceOf(AggregateRoot::class, $product);

        $this->assertInstanceOf(Uuid::class, $product->getUuid());
        $this->assertSame(ProductFactory::UUID, $product->getUuid()->value);

        $this->assertInstanceOf(Title::class, $product->getTitle());
        $this->assertSame(ProductFactory::TITLE, $product->getTitle()->value);

        $this->assertInstanceOf(Category::class, $product->getCategory());
        $this->assertSame(CategoryFactory::UUID, $product->getCategory()->getUuid()->value);

        $this->assertInstanceOf(Description::class, $product->getDescription());
        $this->assertSame(ProductFactory::DESCRIPTION, $product->getDescription()->value);

        $this->assertIsInt($product->getViewedCount());
        $this->assertSame(ProductFactory::VIEWED_COUNT, $product->getViewedCount());

        $this->assertIsBool($product->getIsActive());
        $this->assertSame(ProductFactory::IS_ACTIVE, $product->getIsActive());
    }
}
