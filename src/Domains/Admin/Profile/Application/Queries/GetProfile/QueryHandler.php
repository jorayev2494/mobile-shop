<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Application\Queries\GetProfile;

use Project\Domains\Admin\Profile\Domain\Profile\Profile;
use Project\Domains\Admin\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly ProfileRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Query $query): Profile
    {
        return $this->repository->findByUuid($query->uuid);

    }
}
