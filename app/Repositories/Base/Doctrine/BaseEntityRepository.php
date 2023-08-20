<?php

declare(strict_types=1);

namespace App\Repositories\Base\Doctrine;

use App\Repositories\Contracts\BaseEntityRepositoryInterface;
use App\Repositories\Contracts\BaseModelRepositoryInterface;
use App\Repositories\Pipelines\Filters\RelationFilter;
use App\Repositories\Pipelines\Filters\StringFilter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pipeline\Pipeline;
use Project\Shared\Application\Query\BaseQuery;

abstract class BaseEntityRepository extends EntityRepository // implements BaseEntityRepositoryInterface
{
    protected EntityRepository $entityRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->initRepository($entityManager);
    }

    private function initRepository(EntityManagerInterface $entityManager): void
    {
        if ($this->getEntity()) {
            $this->entityRepository = $entityManager->getRepository($this->getEntity());
        }

    }

    abstract public function getEntity();

    protected function paginator($query, BaseQuery $dataDTO, bool $fetchJoinCollection = true): Paginator
    {
        return new Paginator($query, $dataDTO, $fetchJoinCollection);
    }

    // public function get(array $columns = ['*']): Collection
    // {
    //     return $this->getModelClone()->newQuery()->get($columns);
    // }

    // public function findOrNull(string|int $value, string $field = null, array $columns = ['*']): ?Model
    // {
    //     return $this->getModelClone()->newQuery()
    //                                 ->where($field ?? $this->getModelClone()->getKeyName(), $value)
    //                                 // ->with($this->getWith())
    //                                 ->first($columns);
    // }

    // public function findOrFail(string|int $value, string $field = null, array $columns = ['*']): Model
    // {
    //     return $this->getModelClone()->newQuery()
    //                                 ->where($field ?? $this->getModelClone()->getKeyName(), $value)
    //                                 // ->with($this->getWith())
    //                                 ->firstOrFail($columns);
    // }

    // public function findMany(iterable $values, string $field = null, array $columns = ['*']): Collection
    // {
    //     return $this->getModelClone()->newQuery()
    //                                 ->whereIn($field ?? $this->getModelClone()->getKeyName(), $values)
    //                                 // ->with($this->getWith())
    //                                 ->get($columns);
    // }

    // public function create(array $attributes = []): Model
    // {
    //     $model = $this->getModelClone()->newQuery()->newModelInstance();
    //     $model->fill($attributes);
    //     $model->save();

    //     return $model
    //         ->fresh(
    //             // $this->getWith()
    //         );
    // }

    // public function paginate(BaseQuery $queryData, iterable $columns = ['*']): LengthAwarePaginator
    // {
    //     /** @var Builder $build */
    //     $query = $this->getModelClone()->newQuery();
    //     $query->select($columns);

    //     $this->search($queryData, $query)
    //         ->sort($queryData, $query)
    //         ->filters($queryData, $query);

    //     return $query->paginate($queryData->per_page);
    // }

    // public function cursorPaginate(BaseQuery $queryData, iterable $columns = ['*']): CursorPaginator
    // {
    //     /** @var Builder $build */
    //     $query = $this->getModelClone()->newQuery();
    //     $query->select($columns);

    //     $this->search($queryData, $query)
    //         ->sort($queryData, $query)
    //         ->filters($queryData, $query);

    //     return $query->cursorPaginate($queryData->per_page)->withQueryString();
    // }

    // public function simplePaginate(BaseQuery $queryData, iterable $columns = ['*']): Paginator
    // {
    //     /** @var Builder $build */
    //     $query = $this->getModelClone()->newQuery();
    //     $query->select($columns);

    //     $this->search($queryData, $query)
    //         ->sort($queryData, $query)
    //         ->filters($queryData, $query);

    //     return $query->simplePaginate($queryData->per_page)->withQueryString();
    // }

    // protected function search(BaseQuery $dataDTO, Builder $query = null): self
    // {
    //     $query ??= $this->getModelClone();

    //     if (! is_null($dataDTO->search_by) && ! is_null($dataDTO->search)) {
    //         $query->where($dataDTO->search_by, 'LIKE', "%{$dataDTO->search}%");
    //     }

    //     return $this;
    // }

    // protected function sort(BaseQuery $dataDTO, Builder $query = null): self
    // {
    //     $query ??= $this->getModelClone();

    //     if (! is_null($dataDTO->sort_by)) {
    //         $query->orderBy($dataDTO->sort_by, $dataDTO->is_sort_desc ? 'DESC' : 'ASC');
    //     }

    //     return $this;
    // }

    // public function filters(BaseQuery $dataDTO, Builder $query): self
    // {
    //     $query ??= $this->getModelClone();

    //     /** @var Pipeline $pipeline */
    //     $pipeline = resolve(Pipeline::class);
    
    //     foreach ($dataDTO->filters as $key => ['type' => $type, 'value' => $value]) {
    //         $pipeline->send(compact('query', 'type', 'key', 'value'))
    //             ->through([
    //                 RelationFilter::class,
    //                 StringFilter::class,
    //             ])
    //             ->thenReturn();
    //     }

    //     return $this;
    // }

    // protected function getModelClone(): Model
    // {
    //     return clone $this->model;
    // }
}
