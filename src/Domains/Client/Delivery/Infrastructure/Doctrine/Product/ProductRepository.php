<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Product;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Doctrine\Common\Collections\Collection;
use Project\Domains\Client\Delivery\Domain\Product\Product;
use Project\Domains\Client\Delivery\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Product\ValueObjects\Uuid as ProductUuid;

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

    public function findManyByUuids(array $uuids): Collection
    {
        return $this->entityRepository->createQueryBuilder('p')
                                        ->where('p.Uuid IN (:uuids)')
                                        ->setParameter('uuid', $uuids)
                                        ->getQuery()
                                        ->getResult();
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
