<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Queries\Index;

use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CartRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Query $query)
    {
        return $this->repository->paginate($query);
    }
}
