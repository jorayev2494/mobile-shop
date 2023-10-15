<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Infrastructure\Doctrine\Category;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Category\Domain\Category\Category;
use Project\Domains\Admin\Category\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Category\Domain\Category\ValueObjects\CategoryUuid;
use Project\Shared\Application\Query\BaseQuery;

final class CategoryRepository extends BaseAdminEntityRepository implements CategoryRepositoryInterface
{
    protected function getEntity(): string
    {
        return Category::class;
    }

    public function get(): array
    {
        return $this->entityRepository->findAll();
    }

    public function paginate(BaseQuery $queryData): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('c')->getQuery();

        return $this->paginator($query, $queryData);
    }

    public function findByUuid(CategoryUuid $uuid): ?Category
    {
        return $this->entityRepository->find($uuid->value);
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
