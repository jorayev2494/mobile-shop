<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Queries\GetAddresses;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class QueryService
{
    public function __construct(
        private readonly AddressRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
    )
    {
        
    }

    public function execute(Query $query): Paginator
    {
        return $this->repository->getAuthorUuidPaginate($this->authManager->client()->uuid, $query);
    }
}
