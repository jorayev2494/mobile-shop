<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Application\Subscribers\Product;

use Project\Domains\Admin\Product\Domain\Product\Events\ProductWasDeletedDomainEvent;
use Project\Domains\Client\Delivery\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Product\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProductWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            ProductWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(ProductWasDeletedDomainEvent $event): void
    {
        $product = $this->productRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($product === null) {
            return;
        }

        $this->productRepository->delete($product);
    }
}
