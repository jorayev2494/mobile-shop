<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Product;

use Doctrine\Common\Collections\Collection;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Uuid;

interface ProductRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Product;

    /**
     * @param array<int, Uuid> $uuids
     * @return Collection<int, Product>
     */
    public function findManyByUuids(array $uuids): Collection;

    public function save(Product $product): void;

    public function delete(Product $product): void;
}
