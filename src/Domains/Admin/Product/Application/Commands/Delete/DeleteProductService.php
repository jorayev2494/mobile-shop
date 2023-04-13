<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Product\Domain\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\ValueObjects\ProductUUID;

final class DeleteProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository
    )
    {
        
    }

    public function execute(ProductUUID $uuid): void
    {
        $product = $this->repository->findOrNull($uuid->value);

        if ($product === null) {
            throw new ModelNotFoundException();
        }

        $this->repository->delete($uuid);
    }
}
