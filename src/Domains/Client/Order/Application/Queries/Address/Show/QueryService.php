<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Address\Show;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Order\Domain\Address\Address;
use Project\Domains\Client\Order\Domain\Address\AddressRepositoryInterface;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid;
use Project\Shared\Domain\DomainException;

final class QueryService
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
    ) {

    }

    public function execute(Query $query): Address
    {
        $address = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        $address ?? throw new DomainException('Address not found');

        return $address;
    }
}
