<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application\Subscribers\Product\Media;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductMediaWasAddedDomainEvent;
use Project\Domains\Client\Order\Application\Subscribers\Product\Media\ProductMediaWasAddedDomainEventSubscriber;
use Project\Domains\Client\Order\Domain\Product\Product;
use Project\Domains\Client\Order\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Uuid;
use Project\Domains\Client\Order\Test\Unit\Application\MediaFactory;
use Project\Domains\Client\Order\Test\Unit\Application\ProductFactory;

/**
 * @group order-subscriber
 * @group order-product-subscriber
 * @group order-product-media-subscriber
 */
class ProductMediaWasAddedDomainEventSubscriberTest extends TestCase
{
    public function testEventHandler(): void
    {
        $handler = new ProductMediaWasAddedDomainEventSubscriber(
            $productRepository = $this->createMock(ProductRepositoryInterface::class),
        );

        $product = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'addMedia',
            ])
            ->getMock();

        $product->expects($this->once())
            ->method('addMedia')
            ->with($media = MediaFactory::make());

        $productRepository->expects($this->once())
            ->method('findByUuid')
            ->with(Uuid::fromValue(ProductFactory::UUID))
            ->will($this->returnValue($product));

        $productRepository->expects($this->once())
            ->method('save')
            ->with($product);

        $handler(
            new ProductMediaWasAddedDomainEvent(
                ProductFactory::UUID,
                MediaFactory::make()->toArray(),
            )
        );

    }
}
