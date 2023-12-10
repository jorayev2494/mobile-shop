<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application\Subscribers\Product;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductWasDeletedDomainEvent;
use Project\Domains\Client\Order\Application\Subscribers\Product\ProductWasDeletedDomainEventSubscriber;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Uuid;
use Project\Domains\Client\Order\Infrastructure\Doctrine\Product\ProductRepository;
use Project\Domains\Client\Order\Test\Unit\Application\ProductFactory;

/**
 * @group order-subscriber
 * @group order-product-subscriber
 */
class ProductWasDeletedDomainEventSubscriberTest extends TestCase
{
    public function testSubscribedTo(): void
    {
        $this->assertContainsEquals(
            ProductWasDeletedDomainEvent::class,
            ProductWasDeletedDomainEventSubscriber::subscribedTo()
        );
    }

    public function testEventHandler(): void
    {
        $handler = new ProductWasDeletedDomainEventSubscriber(
            $productRepository = $this->createMock(ProductRepository::class),
        );

        $productRepository->expects($this->once())
            ->method('findByUuid')
            ->with(Uuid::fromValue(ProductFactory::UUID))
            ->will($this->returnVAlue($product = ProductFactory::make()));

        $productRepository->expects($this->once())
            ->method('delete')
            ->with($product);

        $handler(
            new ProductWasDeletedDomainEvent(
                ProductFactory::UUID,
            )
        );
    }

    public function testProductNotFound(): void
    {
        $handler = new ProductWasDeletedDomainEventSubscriber(
            $productRepository = $this->createMock(ProductRepository::class),
        );

        $productRepository->expects($this->once())
            ->method('findByUuid')
            ->with(Uuid::fromValue(ProductFactory::UUID))
            ->willReturn(null);

        $productRepository->expects($this->never())
            ->method('delete');

        $handler(
            new ProductWasDeletedDomainEvent(
                ProductFactory::UUID,
            )
        );
    }
}
