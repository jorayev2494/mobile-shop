<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Subscribers;

use Project\Domains\Admin\Product\Domain\Product\Events\ProductMediaWasAddedDomainEvent;
use Project\Domains\Client\Favorite\Domain\Media\Media;
use Project\Domains\Client\Favorite\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProductMediaWasAddedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            ProductMediaWasAddedDomainEvent::class,
        ];
    }

    public function __invoke(ProductMediaWasAddedDomainEvent $event): void
    {
        [
            'uuid' => $uuid,
            'mime_type' => $mimeType,
            'width' => $width,
            'height' => $height,
            'extension' => $extension,
            'size' => $size,
            'path' => $path,
            'full_path' => $fullPath,
            'file_name' => $fileName,
            'file_original_name' => $fileOriginalName,
            'url' => $url,
            'downloaded_count' => $downloadedCount,
            'url_pattern' => $urlPattern,
        ] = $event->data;

        $media = Media::make($uuid, $mimeType, $width, $height, $extension, $size, $path, $fullPath, $fileName, $fileOriginalName, $url, $downloadedCount, $urlPattern);

        $product = $this->productRepository->findByUuid(ProductUuid::fromValue($event->uuid));
        $product->addMedia($media);

        $this->productRepository->save($product);
    }
}
