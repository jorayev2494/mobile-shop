<?php

declare(strict_types=1);

namespace Project\Domains\PublicApi\Currency\Application\Queries\Index;

use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\PublicApi\Currency\Domain\Currency\CurrencyRepositoryInterface;
use Project\Shared\Domain\Bus\Query\QueryInterface;

class QueryHandler implements QueryInterface
{
    public function __construct(
        private readonly CurrencyRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Query $query)
    {
        $countries = $this->repository->get($query);

        return array_map(static fn (Arrayable $country): array => $country->toArray(), $countries);
    }
}
