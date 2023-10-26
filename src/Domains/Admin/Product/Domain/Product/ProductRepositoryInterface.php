<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Product;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Application\Query\BaseQuery;

interface ProductRepositoryInterface
{
    public function paginate(BaseQuery $queryData): Paginator;

    public function findByUuid(ProductUuid $uuid): ?Product;

    public function save(Product $product): void;

    public function delete(Product $product): void;
}
