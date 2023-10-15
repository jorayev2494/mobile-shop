<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Product\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\FilesystemInterface;

final class DeleteProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly MediaRepositoryInterface $mediaRepository,
        private readonly FilesystemInterface $filesystem,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function execute(ProductUuid $uuid): void
    {
        $product = $this->repository->findByUuid($uuid);

        if ($product === null) {
            throw new ModelNotFoundException();
        }

        $this->removeMedias($product);

        $product->delete();
        $this->repository->delete($product);
        $this->eventBus->publish(...$product->pullDomainEvents());
    }

    private function removeMedias(Product $product): void
    {
        foreach ($product->getMedias() as $media) {
            $product->removeMedia($media);
            $this->filesystem->deleteFile($media);
            $this->mediaRepository->delete($media);
        }
    }
}
