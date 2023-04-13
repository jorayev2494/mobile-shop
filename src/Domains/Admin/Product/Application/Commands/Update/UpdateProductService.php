<?php

namespace Project\Domains\Admin\Product\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Product\Domain\Product;
use Project\Domains\Admin\Product\Domain\ProductRepositoryInterface;

final class UpdateProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
    )
    {

    }

    public function execute(Product $product): array
    {
        $foundProduct = $this->repository->findOrNull($product->uuid->value);

        if ($foundProduct === null) {
            throw new ModelNotFoundException();
        }

        $this->repository->save($product);

        return ['uuid' => $product->uuid->value];
    }
}
