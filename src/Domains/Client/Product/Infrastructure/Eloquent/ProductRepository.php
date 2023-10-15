<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Infrastructure\Eloquent;

use App\Repositories\Base\Doctrine\Paginator;
use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Client\Product\Domain\ProductRepositoryInterface;
use Project\Domains\Client\Product\Domain\ValueObjects\ProductUuid;
use Project\Shared\Application\Query\BaseQuery;

final class ProductRepository extends BaseAdminEntityRepository implements ProductRepositoryInterface
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
        $product = $this->entityRepository->find($uuid->value);

        if ($product === null) {
            return null;
        }

        return $product;
    }


}
