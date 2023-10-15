<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Get;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Order\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\AuthorUuid;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\StatusEnum;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
    ) {

    }

    public function __invoke(Query $query): Paginator
    {
        return $this->repository->paginateByAuthorUuid(AuthorUuid::fromValue($this->authManager->client()->uuid), $query, StatusEnum::from($query->status));
    }
}
