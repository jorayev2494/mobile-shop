<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Subscribers;

use Project\Domains\Admin\Product\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductWasDeletedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Shared\Domain\FilesystemInterface;

final class ProductWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{

    public function __construct(
        private readonly FilesystemInterface $filesystem,
        private readonly MediaRepositoryInterface $fileRepository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [ProductWasDeletedDomainEvent::class];
    }

    public function __invoke(ProductWasDeletedDomainEvent $event): void
    {
        $medias = $this->fileRepository->findManyByProductUuid(ProductUuid::fromValue($event->uuid));

        foreach ($medias as $key => $media) {
            $this->filesystem->deleteFile($media);
            $media->delete();
        }
    }
}
