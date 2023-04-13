<?php

declare(strict_types=1);

namespace App\Repositories\Contracts\Queries;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Shared\Application\Query\BaseQuery;

interface PaginateInterface
{
    public function paginate(BaseQuery $dataDTO, iterable $columns = ['*']): LengthAwarePaginator;
}
