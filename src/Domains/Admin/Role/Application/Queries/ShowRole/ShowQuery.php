<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Queries\ShowRole;

use Project\Shared\Application\Query\Query;

final class ShowQuery extends Query
{
    public function __construct(
        public readonly int $id,
    )
    {

    }
}
