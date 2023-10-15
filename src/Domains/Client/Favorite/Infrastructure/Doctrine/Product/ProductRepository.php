<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Infrastructure\Doctrine\Product;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUuid;
use Project\Domains\Client\Favorite\Domain\Product\Product;
use Project\Domains\Client\Favorite\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductUuid;
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

    public function memberFavoriteProducts(MemberUuid $uuid, BaseQuery $queryData): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('p')
                                        ->innerJoin('p.members', 'm')
                                        ->where('m.uuid = :uuid')
                                        ->setParameter('uuid', $uuid)
                                        ->getQuery();

        return $this->paginator($query, $queryData);
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
