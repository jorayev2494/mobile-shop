<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Delivery\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Card\Card;
use Project\Domains\Client\Delivery\Domain\Card\ValueObjects\Uuid;

final class CardRepository extends BaseClientEntityRepository implements CardRepositoryInterface
{
    protected function getEntity(): string
    {
        return Card::class;
    }

    public function findByUuid(Uuid $uuid): ?Card
    {
        return $this->entityRepository->find($uuid);
    }

    public function delete(Card $card): void
    {
        $this->entityRepository->getEntityManager()->remove($card);
        $this->entityRepository->getEntityManager()->flush();
    }
}
