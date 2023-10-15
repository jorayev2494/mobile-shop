<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Infrastructure\Doctrine\Product;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Cart\Domain\Member\ValueObjects\Uuid;
use Project\Domains\Client\Cart\Domain\Product\Product;
use Project\Domains\Client\Cart\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\Uuid as ProductUuid;
use Project\Shared\Application\Query\BaseQuery;

class ProductRepository extends BaseClientEntityRepository implements ProductRepositoryInterface
{
    protected function getEntity(): string
    {
        return Product::class;
    }

    public function findByUuid(ProductUuid $uuid): ?Product
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Product $product): void
    {
        $this->entityRepository->getEntityManager()->persist($product);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Product $product): void
    {
        $this->entityRepository->getEntityManager()->remove($product);
        $this->entityRepository->getEntityManager()->flush();
    }

}
