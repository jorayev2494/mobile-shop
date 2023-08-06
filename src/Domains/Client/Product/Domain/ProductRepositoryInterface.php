<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Domain;

use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Pagination\Paginator;
use Project\Domains\Client\Product\Domain\ValueObjects\ProductUUID;
use Project\Shared\Application\Query\BaseQuery;

interface ProductRepositoryInterface extends BaseModelRepositoryInterface
{
    public function indexSimplePaginate(BaseQuery $queryData, iterable $columns = ['*']): Paginator;
    public function findByUUID(ProductUUID $uuid): ?Product;
}
