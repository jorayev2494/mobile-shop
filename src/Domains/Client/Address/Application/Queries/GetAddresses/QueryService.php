<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Queries\GetAddresses;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressAuthorUuid;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\AuthorUuid;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class QueryService
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
    )
    {
        
    }

    public function execute(Query $query): array
    {
        return $this->repository->getByAuthorUuid(AddressAuthorUuid::fromValue($this->authManager->client()->uuid), $query);
    }
}
