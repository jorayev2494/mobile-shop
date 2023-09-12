<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Subscribers;

use App\Models\File;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductWasDeletedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Shared\Domain\FilesystemInterface;

final class ProductWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{

    public function __construct(
        private readonly FilesystemInterface $filesystem,
        private readonly File $fileRepository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [ProductWasDeletedDomainEvent::class];
    }

    public function __invoke(ProductWasDeletedDomainEvent $event): void
    {
        $files = $this->fileRepository->newQuery()->where('fileable_uuid', $event->uuid)->get();
        info('Found delete files: ', $files->toArray());
        /** @var File $file */
        foreach ($files as $key => $file) {
            $this->filesystem->deleteFile($file->path, $file->name);
            $file->delete();
        }
    }
}
