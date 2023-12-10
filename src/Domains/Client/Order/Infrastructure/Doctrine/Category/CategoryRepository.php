<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Category;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Order\Domain\Category\Category;
use Project\Domains\Client\Order\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Client\Order\Domain\Category\ValueObjects\Uuid;
use Project\Shared\Application\Query\BaseQuery;

final class CategoryRepository extends BaseClientEntityRepository implements CategoryRepositoryInterface
{
    protected function getEntity(): string
    {
        return Category::class;
    }

    public function get(BaseQuery $baseQuery): array
    {
        return $this->entityRepository->createQueryBuilder('c')
                                        ->getQuery()
                                        ->getResult();
    }

    public function findByUuid(Uuid $uuid): ?Category
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Category $category): void
    {
        $this->entityRepository->getEntityManager()->persist($category);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Category $category): void
    {
        $this->entityRepository->getEntityManager()->remove($category);
        $this->entityRepository->getEntityManager()->flush();
    }
}
