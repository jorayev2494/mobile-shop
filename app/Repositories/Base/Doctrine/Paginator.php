<?php

declare(strict_types=1);

namespace App\Repositories\Base\Doctrine;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as OrmPaginator;
use Illuminate\Contracts\Support\Arrayable;
use Project\Shared\Application\Query\BaseQuery;

/**
 * @see https://gist.github.com/Naskalin/6306172b8081813ea213099a4d16019a
 * @see https://brennanwal.sh/article/how-to-paginate-doctrine-entities-with-symfony-5
 * @see https://api-platform.com/docs/core/pagination/
 */
class Paginator implements Arrayable
{
    private int $page;
    private ?int $nextPage;

    private int $total;

    private int $lastPage;

    private iterable $items;

    /**
     * @param QueryBuilder|Query $query
     * @param int $page
     * @param int $limit
     * @return Paginator
     */
    public function __construct($query, BaseQuery $dataDTO, bool $fetchJoinCollection = true)
    {
        $paginator = new OrmPaginator($query, $fetchJoinCollection);

        $paginator
            ->getQuery()
            ->setFirstResult($dataDTO->per_page * ($dataDTO->page - 1))
            ->setMaxResults($dataDTO->per_page);

        $this->makeControl($paginator, $dataDTO);
    }

    private function makeControl(OrmPaginator $paginator, BaseQuery $dataDTO): void
    {
        $this->page = $dataDTO->page;
        $this->items = array_map(static fn (Arrayable $item): array => $item->toArray(), iterator_to_array($paginator->getIterator()));
        $this->lastPage = (int) ceil($paginator->count() / $paginator->getQuery()->getMaxResults());
        $this->nextPage = ($nexPage = $dataDTO->page + 1) <= $this->lastPage ? $nexPage : null;
        $this->total = $paginator->count();
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function nextPage(): ?int
    {
        return $this->nextPage;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    public function getItems(): iterable
    {
        return $this->items;
    }

    public function toArray(): array
    {
        return [
            'page' => $this->page,
            'data' => $this->items,
            'next_page' => $this->nextPage,
            'last_page' => $this->lastPage,
            'total' => $this->total,
        ];
    }
}
