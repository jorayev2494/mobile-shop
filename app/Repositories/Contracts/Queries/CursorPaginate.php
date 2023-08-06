<?php

declare(strict_types=1);

namespace App\Repositories\Contracts\Queries;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Project\Shared\Application\Query\BaseQuery;

interface CursorPaginate
{
    public function cursorPaginate(BaseQuery $queryData, iterable $columns = ['*']): CursorPaginator;
}
