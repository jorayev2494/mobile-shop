<?php

declare(strict_types=1);

namespace App\Repositories\Contracts\Queries;

use Illuminate\Contracts\Pagination\Paginator;
use Project\Shared\Application\Query\BaseQuery;

interface SimplePaginate
{
    public function simplePaginate(BaseQuery $queryData, iterable $columns = ['*']): Paginator;
}
