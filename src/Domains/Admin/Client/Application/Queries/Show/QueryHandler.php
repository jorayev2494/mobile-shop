<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Application\Queries\Show;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Client\Domain\Client\Client;
use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientUuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly ClientRepositoryInterface $repository,
    ) {

    }

    public function __invoke(Query $query): Client
    {
        $client = $this->repository->findByUuid(ClientUuid::fromValue($query->uuid));

        $client ?? throw new ModelNotFoundException();

        return $client;
    }
}
