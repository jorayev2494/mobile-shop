<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application\Subscribers\Product\Media;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductMediaWasDeletedDomainEvent;
use Project\Domains\Client\Order\Application\Subscribers\Product\Media\ProductMediaWasDeletedDomainEventSubscriber;
use Project\Domains\Client\Order\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Client\Order\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Uuid;
use Project\Domains\Client\Order\Test\Unit\Application\MediaFactory;
use Project\Domains\Client\Order\Test\Unit\Application\ProductFactory;

/**
 * @group order-subscriber
 * @group order-product-subscriber
 * @group order-product-media-subscriber
 */
class ProductMediaWasDeletedDomainEventSubscriberTest extends TestCase
{
    public function testEventHandler(): void
    {
        $handler = new ProductMediaWasDeletedDomainEventSubscriber(
            $productRepository = $this->createMock(ProductRepositoryInterface::class),
            $mediaRepository = $this->createMock(MediaRepositoryInterface::class),
        );

        $productRepository->expects($this->once())
            ->method('findByUuid')
            ->with(Uuid::fromValue(ProductFactory::UUID))
            ->will($this->returnValue($product = ProductFactory::makeWithMedia()));

        $mediaRepository->expects($this->once())
            ->method('delete')
            ->with($product->getMedias()[0]);

        $handler(
            new ProductMediaWasDeletedDomainEvent(
                ProductFactory::UUID,
                MediaFactory::UUID,
            )
        );

    }
}
