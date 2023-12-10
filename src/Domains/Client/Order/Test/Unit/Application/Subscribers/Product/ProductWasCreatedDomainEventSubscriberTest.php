<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application\Subscribers\Product;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductWasCreatedDomainEvent;
use Project\Domains\Client\Order\Application\Subscribers\Product\ProductWasCreatedDomainEventSubscriber;
use Project\Domains\Client\Order\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Client\Order\Domain\Category\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Order\Test\Unit\Application\CategoryFactory;
use Project\Domains\Client\Order\Test\Unit\Application\PriceFactory;
use Project\Domains\Client\Order\Test\Unit\Application\ProductFactory;

/**
 * @group order-subscriber
 * @group order-product-subscriber
 */
class ProductWasCreatedDomainEventSubscriberTest extends TestCase
{
    public function testSubscribedTo(): void
    {
        $this->assertContainsEquals(
            ProductWasCreatedDomainEvent::class,
            ProductWasCreatedDomainEventSubscriber::subscribedTo()
        );
    }

    public function testEventHandler(): void
    {
        $handler = new ProductWasCreatedDomainEventSubscriber(
            $productRepository = $this->createMock(ProductRepositoryInterface::class),
            $categoryRepository = $this->createMock(CategoryRepositoryInterface::class),
        );

        $categoryRepository->expects($this->once())
            ->method('findByUuid')
            ->with(Uuid::fromValue(CategoryFactory::UUID))
            ->will($this->returnVAlue($category = CategoryFactory::make()));

        $productRepository->expects($this->once())
            ->method('save')
            ->with($el = ProductFactory::make());

        $handler(
            new ProductWasCreatedDomainEvent(
                ProductFactory::UUID,
                ProductFactory::TITLE,
                CategoryFactory::UUID,
                PriceFactory::make()->toArray(),
                ProductFactory::VIEWED_COUNT,
                ProductFactory::DESCRIPTION,
                ProductFactory::IS_ACTIVE,
            )
        );

    }
}
