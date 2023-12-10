<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Address\GetAddresses;

use Project\Domains\Client\Order\Domain\Address\AddressRepositoryInterface;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\AuthorUuid;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class QueryService
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
    ) {

    }

    public function execute(Query $query): array
    {
        return $this->repository->getByAuthorUuid(AuthorUuid::fromValue($this->authManager->client()->getUuid()), $query);
    }
}
