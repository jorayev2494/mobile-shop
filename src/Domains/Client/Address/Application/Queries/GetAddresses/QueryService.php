<?php

declare(strict_types=1);

namespace Project\Domains\Client\Address\Application\Queries\GetAddresses;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    public function execute(Query $query): LengthAwarePaginator
    {
        // return $this->repository->getClientAddressesPaginate($this->authManager->client()->uuid, $query);
        return $this->repository->paginate($query);
    }
}
