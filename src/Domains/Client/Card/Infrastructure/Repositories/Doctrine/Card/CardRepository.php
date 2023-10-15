<?php

declare(strict_types=1);

namespace Project\Domains\Client\Card\Infrastructure\Repositories\Doctrine\Card;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Card\Domain\Card\Card;
use Project\Domains\Client\Card\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\AuthorUuid;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Uuid;
use Project\Shared\Application\Query\BaseQuery;

final class CardRepository extends BaseClientEntityRepository implements CardRepositoryInterface
{
    protected function getEntity(): string
    {
        return Card::class;
    }

    public function getByAuthorUuid(AuthorUuid $authorUuid, BaseQuery $queryData): array
    {
        return $this->entityRepository->createQueryBuilder('c')
                                        ->where('c.authorUuid = :authorUuid')
                                        ->setParameter('authorUuid', $authorUuid)
                                        ->getQuery()
                                        ->getResult();
    }

    public function paginateByAuthorUuid(AuthorUuid $authorUuid, BaseQuery $queryData): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('c')
                                        ->where('c.authorUuid = :authorUuid')
                                        ->setParameter('authorUuid', $authorUuid)
                                        ->getQuery();

        return $this->paginator($query, $queryData);
    }

    public function findByUuid(Uuid $uuid): ?Card
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Card $card): void
    {
        $this->entityRepository->getEntityManager()->persist($card);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Card $card): void
    {
        $this->entityRepository->getEntityManager()->remove($card);
        $this->entityRepository->getEntityManager()->flush();
    }
}
