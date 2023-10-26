<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Category;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Delivery\Domain\Category\Category;
use Project\Domains\Client\Delivery\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Category\ValueObjects\Uuid;

final class CategoryRepository extends BaseClientEntityRepository implements CategoryRepositoryInterface
{
    protected function getEntity(): string
    {
        return Category::class;
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
