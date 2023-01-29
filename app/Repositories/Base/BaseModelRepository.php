<?php

declare(strict_types=1);

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModelRepository
{
    protected Model $model;

    public function __construct()
    {
        $this->initRepository();
    }

    private function initRepository(): void
    {
        if ($this->getModel()) {
            $this->model = app()->make($this->getModel());
        }
    }

    abstract public function getModel(): string;

    public function get(array $columns = ['*']): Collection
    {
        return $this->getModelClone()->newQuery()->get($columns);
    }

    public function findOrNull(string|int $value, string $field = 'id', array $columns = ['*']): ?Model
    {
        return $this->getModelClone()->newQuery()
                                    ->where($field, $value)
                                    // ->with($this->getWith())
                                    ->first($columns);
    }

    public function findOrFail(string|int $value, string $field = 'id', array $columns = ['*']): Model
    {
        return $this->getModelClone()->newQuery()
                                    ->where($field, $value)
                                    // ->with($this->getWith())
                                    ->firstOrFail($columns);
    }

    public function findMany(iterable $values, string $field = 'id', array $columns = ['*']): Collection
    {
        return $this->getModelClone()->newQuery()
                                    ->whereIn($field, $values)
                                    // ->with($this->getWith())
                                    ->get($columns);
    }

    public function create(array $attributes = []): Model
    {
        $model = $this->getModelClone()->newQuery()->newModelInstance();
        $model->fill($attributes);
        $model->save();

        return $model
            ->fresh(
                // $this->getWith()
            );
    }

    protected function getModelClone(): Model
    {
        return clone $this->model;
    }
}
