<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Domain\Media;

interface MediaRepositoryInterface
{
    public function findByUuid(string $uuid): ?Media;
    // public function findProductMediasByIds(string $productId, array $ids): iterable;

    // public function delete(Media $media): void;
}
