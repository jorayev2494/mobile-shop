<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Queries\Show;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Card\Domain\Card\Card;
use Project\Domains\Client\Card\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CardRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(Query $query): ?Card
    {
        $card = $this->repository->findByUuid(Uuid::fromValue($query->uuid));

        if ($card === null) {
            throw new ModelNotFoundException();
        }

        return $card;
    }
}