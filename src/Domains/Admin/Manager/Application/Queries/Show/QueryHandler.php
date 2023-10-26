<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Queries\Show;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\DomainException;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Query $query): Manager
    {
        $manager = $this->repository->findByUuid(ManagerUuid::fromValue($query->uuid));

        if ($manager === null) {
            throw new DomainException('Manager not found', 404);
        }

        return $manager;
    }
}
