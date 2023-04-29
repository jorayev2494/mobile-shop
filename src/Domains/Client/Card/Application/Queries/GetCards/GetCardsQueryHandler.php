<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Queries\GetCards;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Client\Card\Domain\CardRepositoryInterface;
use Project\Domains\Client\Card\Domain\ValueObjects\CardClientUUID;
use Project\Shared\Domain\Bus\Query\QueryHandler;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class GetCardsQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly CardRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
    )
    {
        
    }

    public function __invoke(GetCardsQuery $query): LengthAwarePaginator
    {
        $cardClientUUID = CardClientUUID::fromValue($this->authManager->client()->uuid);

        return $this->repository->getClientCardsPaginate($cardClientUUID, $query);
    }
}
