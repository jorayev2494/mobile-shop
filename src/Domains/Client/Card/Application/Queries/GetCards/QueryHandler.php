<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Queries\GetCards;

use Illuminate\Contracts\Support\Arrayable;
use Project\Domains\Client\Card\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\AuthorUuid;
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
            AuthorUuid::fromValue($this->authManager->client()->uuid),
            $query
        );

        return array_map(
            static fn (Arrayable $card): array => $card->toArray(),
            $cards
        );
    }
}
