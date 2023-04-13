<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Queries\Find;

use Project\Shared\Application\Query\Query;

final class FindCategoryQuery extends Query
{
    public function __construct(
        public readonly string $uuid,
    )
    {
        
    }
}
