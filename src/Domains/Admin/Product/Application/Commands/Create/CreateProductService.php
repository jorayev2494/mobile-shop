<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Create;

use Illuminate\Http\UploadedFile;
use Project\Domains\Admin\Product\Domain\Product;
use Project\Domains\Admin\Product\Domain\ProductRepositoryInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\FilesystemInterface;

final class CreateProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly FilesystemInterface $filesystem,
        private readonly EventBusInterface $eventBus,
    )
    {

    }

    public function execute(Product $product): void
    {
        $this->uploadMedias($product);
        $this->repository->save($product);
        $this->eventBus->publish(...$product->pullDomainEvents());
    }

    private function uploadMedias(Product $product): void
    {
        // $uploadedMedias = [];

        $uploadedFiles = $product->medias;
        $product->medias = [];

        /** @var UploadedFile $media */
        foreach ($uploadedFiles as $key => $media) {
            $uploadedMedia = $this->filesystem->uploadFile(Product::MEDIA_PATH, $media);
            // $uploadedMedias[] = $uploadedMedia;
            $product->addMedia($uploadedMedia);
            // $product->addMedia($this->filesystem->uploadFile(Product::MEDIA_PATH, $media));
        }

        // $product->addMedias($uploadedMedias);
    }
}
