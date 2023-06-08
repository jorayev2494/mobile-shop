<?php

namespace Project\Domains\Admin\Product\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\UploadedFile;
use Project\Domains\Admin\Product\Domain\Product;
use Project\Domains\Admin\Product\Domain\ProductRepositoryInterface;
use Project\Shared\Domain\FilesystemInterface;

final class UpdateProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly FilesystemInterface $filesystem,
    )
    {

    }

    public function execute(Product $product): array
    {
        $foundProduct = $this->repository->findOrNull($product->uuid->value);

        if ($foundProduct === null) {
            throw new ModelNotFoundException();
        }

        $this->uploadMedias($product);
        $this->repository->save($product);

        return ['uuid' => $product->uuid->value];
    }

    private function uploadMedias(Product $product): void
    {
        $uploadedMedias = [];
        /** @var UploadedFile $media */
        foreach ($product->medias as $key => $media) {
            $uploadedMedias[] = $this->filesystem->uploadFile(Product::MEDIA_PATH, $media);
        }

        $product->setMedias($uploadedMedias);
    }
}
