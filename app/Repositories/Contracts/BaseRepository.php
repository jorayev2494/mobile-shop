<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Repositories\Contracts\Queries\PaginateInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepository extends PaginateInterface
{
    public function get(array $columns = ['*']): Collection;

    public function findOrNull(string|int $value, string $field = null, array $columns = ['*']): ?Model;

    public function findOrFail(string|int $value, string $field = null, array $columns = ['*']): Model;

    public function findMany(iterable $values, string $field = null, array $columns = ['*']): Collection;

    public function create(array $attributes = []): Model;

}
