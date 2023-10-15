<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Queries\Show;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Address\Domain\Address;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUuid;

final class QueryService
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
    )
    {
        
    }

    public function execute(Query $query): Address
    {
        $address = $this->repository->findByUuid(AddressUuid::fromValue($query->uuid));
        
        $address ?? throw new ModelNotFoundException();

        return $address;
    }
}
