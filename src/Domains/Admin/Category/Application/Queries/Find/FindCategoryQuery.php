<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Queries\Find;

use Project\Shared\Application\Query\Query;
use Project\Shared\Domain\Bus\Query\QueryInterface;

final class FindCategoryQuery extends Query implements QueryInterface
{
    public function __construct(
        public readonly string $uuid,
    )
    {
        
    }
}
