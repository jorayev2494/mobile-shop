<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Queries\Find;

use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUUID;

final class FindAddressQueryService
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
    )
    {
        
    }

    public function execute(FindAddressQuery $query): object
    {
        $address = $this->repository->findAddress(AddressUUID::fromValue($query->uuid));

        return $address;
    }
}
