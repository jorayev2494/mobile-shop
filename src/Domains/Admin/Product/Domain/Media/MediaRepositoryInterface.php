<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Media;

use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;

interface MediaRepositoryInterface
{
    public function findManyByProductUuid(ProductUuid $productUuid): iterable;

    /**
     * @param string $productId
     * @param string[] $ids
     * @return iterable<Media>
     */
    public function findProductMediasByIds(string $productId, array $ids): iterable;

    public function delete(Media $media): void;
}
