<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Domain;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Product\Domain\ValueObjects\ProductUuid;
use Project\Shared\Application\Query\BaseQuery;
use Project\Domains\Admin\Product\Domain\Product\Product;

interface ProductRepositoryInterface
{
    public function paginate(BaseQuery $queryData): Paginator;
    public function findByUuid(ProductUuid $uuid): ?Product;
}
