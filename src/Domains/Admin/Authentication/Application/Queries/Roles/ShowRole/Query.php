<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Application\Queries\Roles\ShowRole;

use Project\Shared\Domain\Bus\Query\QueryInterface;

final class Query implements QueryInterface
{
    public function __construct(
        public readonly int $id,
    ) {

    }
}
