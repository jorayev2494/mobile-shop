<?php

declare(strict_types=1);

namespace Project\Domains\PublicApi\Country\Application\Queries\Index;

use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\PublicApi\Country\Domain\CountryRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryInterface;

class QueryHandler implements QueryInterface
{
    public function __construct(
        private readonly CountryRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Query $query)
    {
        $countries = $this->repository->get($query);

        return array_map(static fn (Arrayable $country): array => $country->toArray(), $countries);
    }
}
