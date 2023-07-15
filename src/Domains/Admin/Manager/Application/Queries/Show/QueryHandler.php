<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Application\Queries\Show;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Manager\Domain\Manager;
use Project\Domains\Admin\Manager\Domain\ManagerRepositoryInterface;
use Project\Domains\Admin\Manager\Domain\ValueObjects\ManagerUUID;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly ManagerRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Query $query): Manager
    {
        $manager = $this->repository->findByUUID(ManagerUUID::fromValue($query->uuid));

        if ($manager === null) {
            throw new ModelNotFoundException();
        }

        return $manager;
    }
}
