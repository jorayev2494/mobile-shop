<?php

declare(strict_types=1);

namespace Project\Domains\Client\Country\Application\Queries\Index;

use Project\Domains\Client\Country\Domain\CountryRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryInterface;

class QueryHandler implements QueryInterface
{
    public function __construct(
        private readonly CountryRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Query $query)
    {
        return $this->repository->get();
    }
}
