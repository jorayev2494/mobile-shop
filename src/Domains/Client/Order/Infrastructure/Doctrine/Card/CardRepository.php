<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\Card;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Order\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Order\Domain\Card\Card;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Uuid;

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
