<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Create;

use Illuminate\Http\UploadedFile;
use Project\Domains\Admin\Product\Domain\Product;
use Project\Domains\Admin\Product\Domain\ProductRepositoryInterface;

final class CreateProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
    )
    {

    }

    public function execute(Product $product): void
    {
        /** @var UploadedFile $media */
        foreach ($product->medias as $key => $media) {
            
        }

        $this->repository->save($product);
    }
}
