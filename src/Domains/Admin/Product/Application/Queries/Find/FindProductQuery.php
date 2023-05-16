<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Queries\Find;

use Project\Shared\Application\Query\Query;

final class FindProductQuery extends Query
{
    public function __construct(
        public readonly string $uuid,
    )
    {

    }
}
