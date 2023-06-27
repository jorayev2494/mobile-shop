<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain;

use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Admin\Product\Domain\ValueObjects\ProductUUID;
use Project\Shared\Application\Query\BaseQuery;

interface ProductRepositoryInterface extends BaseModelRepositoryInterface
{
    public function getPaginate(BaseQuery $queryData, iterable $columns = ['*']): LengthAwarePaginator;
    public function save(Product $product): bool;
    public function delete(ProductUUID $uuid): void;
}
