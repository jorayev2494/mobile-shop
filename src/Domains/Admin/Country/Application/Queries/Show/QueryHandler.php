<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Queries\Show;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Country\Domain\Country;
use Project\Domains\Admin\Country\Domain\CountryEntity;
use Project\Domains\Admin\Country\Domain\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUUID;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CountryRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Query $query): CountryEntity
    {
        $country = $this->repository->findByUUID(CountryUUID::fromValue($query->uuid));

        if ($country === null) {
            throw new ModelNotFoundException();
        }

        return $country;
    }
}
