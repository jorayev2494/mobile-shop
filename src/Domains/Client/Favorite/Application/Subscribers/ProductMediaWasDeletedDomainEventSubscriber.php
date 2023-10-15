<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Subscribers;

use Project\Domains\Admin\Product\Domain\Product\Events\ProductMediaWasDeletedDomainEvent;
use Project\Domains\Client\Favorite\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProductMediaWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly MediaRepositoryInterface $mediaRepository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            ProductMediaWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(ProductMediaWasDeletedDomainEvent $event): void
    {
        $product = $this->productRepository->findByUuid(ProductUuid::fromValue($event->uuid));
        $media = $this->mediaRepository->findByUuid($event->mediaId);

        if ($product === null || $media === null) {
            return;
        }

        $product->removeMedia($media);
        $this->productRepository->save($product);
    }
}
