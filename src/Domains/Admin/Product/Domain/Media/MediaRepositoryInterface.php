<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Media;

interface MediaRepositoryInterface
{
    public function findProductMediasByIds(string $productId, array $ids): iterable;

    public function delete(Media $media): void;
}
