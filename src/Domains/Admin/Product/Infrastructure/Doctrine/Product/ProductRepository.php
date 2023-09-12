<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Infrastructure\Doctrine\Product;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Application\Query\BaseQuery;

class ProductRepository extends BaseAdminEntityRepository implements ProductRepositoryInterface
{
    protected function getEntity(): string
    {
        return Product::class;
    }

    public function paginate(BaseQuery $queryData): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('p')
                                        ->getQuery();

        return $this->paginator($query, $queryData);
    }

    public function findByUuid(ProductUuid $uuid): ?Product
    {
        return $this->entityRepository->find($uuid->value);
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
