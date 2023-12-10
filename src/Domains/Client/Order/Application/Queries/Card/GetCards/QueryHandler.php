<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Card\GetCards;

use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Client\Order\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\ClientUuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CardRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
    ) {

    }

    public function __invoke(Query $query): array
    {
        $cards = $this->repository->getByAuthorUuid(
            ClientUuid::fromValue($this->authManager->client()->getUuid()),
            $query
        );

        return array_map(
            static fn (Arrayable $card): array => $card->toArray(),
            $cards
        );
    }
}
