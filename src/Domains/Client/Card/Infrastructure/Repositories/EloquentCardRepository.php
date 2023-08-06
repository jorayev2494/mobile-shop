<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Infrastructure\Repositories;

use App\Repositories\Base\BaseModelRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Client\Card\Domain\Card;
use Project\Domains\Client\Card\Domain\CardRepositoryInterface;
use Project\Domains\Client\Card\Domain\ValueObjects\CardClientUUID;
use Project\Domains\Client\Card\Domain\ValueObjects\CardUUID;
use Project\Shared\Application\Query\BaseQuery;

final class EloquentCardRepository extends BaseModelRepository implements CardRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\Card::class;
    }

    public function getClientCardsPaginate(CardClientUUID $uuid, BaseQuery $queryData): LengthAwarePaginator
    {
        $query = $this->getModelClone()->newQuery()->where('client_uuid', $uuid->value);

        $this->search($queryData, $query)
            ->sort($queryData, $query)
            ->filters($queryData, $query);

        return $query->paginate($queryData->per_page);
    }

    public function find(CardUUID $uuid): ?Card
    {
        /** @var \App\Models\Card $foundCard */
        $foundCard = $this->findOrNull($uuid->value);

        if ($foundCard === null) {
            return null;
        }

        $card = Card::fromPrimitives(
            $foundCard->uuid,
            $foundCard->client_uuid,
            $foundCard->type,
            $foundCard->holder_name,
            $foundCard->number,
            $foundCard->cvv,
            $foundCard->expiration_date,
            $foundCard->is_active,
        );

        return $card;
    }

    public function save(Card $card): bool
    {
        return (bool) $this->getModelClone()->newQuery()->updateOrCreate(
            ['uuid' => $card->uuid->value],
            $card->toArray(),
        );
    }

    public function delete(CardUUID $uuid): void
    {
        $this->getModelClone()->newQuery()->find($uuid->value)->delete();
    }
}
