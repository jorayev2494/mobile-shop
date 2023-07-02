<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Queries\ShowRole;

use Project\Shared\Domain\Bus\Query\QueryInterface;

final class ShowQuery implements QueryInterface
{
    public function __construct(
        public readonly int $id,
    )
    {

    }
}
