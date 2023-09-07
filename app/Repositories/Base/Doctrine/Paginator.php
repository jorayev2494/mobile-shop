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
    private int $perPage;
    private ?int $nextPage;

    private int $total;

    private ?int $lastPage;

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
            ->setFirstResult($dataDTO->perPage * ($dataDTO->page - 1))
            ->setMaxResults($dataDTO->perPage);

        $this->makeControl($paginator, $dataDTO);
    }

    private function makeControl(OrmPaginator $paginator, BaseQuery $dataDTO): void
    {
        $this->page = $dataDTO->page;
        $this->perPage = $dataDTO->perPage;
        $this->items = array_map(static fn (Arrayable $item): array => $item->toArray(), iterator_to_array($paginator->getIterator()));
        $this->lastPage = ($lastPage = (int) ceil($paginator->count() / $paginator->getQuery()->getMaxResults())) > 0 ? $lastPage : null;
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
            'current_page' => $this->page,
            'data' => $this->items,
            'next_page' => $this->nextPage,
            'next_page_url' => $this->makePageUrl($this->nextPage),
            'last_page' => $this->lastPage,
            'last_page_url' => $this->makePageUrl($this->lastPage),
            'per_page' => $this->perPage,
            'total' => $this->total,
        ];
    }

    private function makePageUrl(?int $page): ?string
    {
        if ($page === null) {
            return null;
        }

        return sprintf(
            '%s?%s',
            request()->url(),
            http_build_query([
                'page' => $page,
                'per_page' => $this->perPage,
                ...$_REQUEST,
            ])
        );
    }
}
