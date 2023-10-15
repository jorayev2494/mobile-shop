<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Subscribers\Product\Media;

use Project\Domains\Admin\Product\Domain\Product\Events\ProductMediaWasDeletedDomainEvent;
use Project\Domains\Client\Cart\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\Uuid;
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
        $product = $this->productRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($product === null) {
            return;
        }

        foreach ($product->getMedias() as $media) {
            if ($media->getUuid() === $event->mediaId) {
                $product->removeMedia($media);
                $this->mediaRepository->delete($media);
            }
        }
    }
}
