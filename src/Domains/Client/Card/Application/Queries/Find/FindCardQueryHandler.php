<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Application\Queries\Find;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Card\Domain\Card;
use Project\Domains\Client\Card\Domain\CardRepositoryInterface;
use Project\Domains\Client\Card\Domain\ValueObjects\CardUUID;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;

final class FindCardQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CardRepositoryInterface $repository,
    )
    {
        
    }

    public function __invoke(FindCardQuery $query): Card
    {
        $foundCard = $this->repository->find(CardUUID::fromValue($query->uuid));

        if ($foundCard === null) {
            throw new ModelNotFoundException();
        }

        return $foundCard;
    }
}