<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure\Doctrine\Order;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Delivery\Domain\Order\Order;
use Project\Domains\Client\Delivery\Domain\Order\ValueObjects\Uuid;
use Project\Domains\Client\Delivery\Domain\Order\ValueObjects\AuthorUuid;
use Project\Domains\Client\Delivery\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Order\ValueObjects\StatusEnum;
use Project\Shared\Application\Query\BaseQuery;

final class OrderRepository extends BaseClientEntityRepository implements OrderRepositoryInterface
{
    public function getEntity(): string
    {
        return Order::class;
    }

    public function findByUuid(Uuid $uuid): ?Order
    {
        return $this->entityRepository->find($uuid);
    }

    public function findByAuthorUuid(AuthorUuid $authorUuid): ?Order
    {
        return $this->entityRepository->findOneBy(['authorUuid' => $authorUuid]);
    }

    public function paginateByAuthorUuid(AuthorUuid $authorUuid, BaseQuery $queryDTO, StatusEnum $status): Paginator
    {
        // dd($status);
        $query = $this->entityRepository->createQueryBuilder('o')
                                        ->where('o.authorUuid = :authorUuid')
                                        ->andWhere('o.status = :status')
                                        ->setParameter('authorUuid', $authorUuid)
                                        ->setParameter('status', $status)
                                        ->getQuery();

        return $this->paginator($query, $queryDTO);
    }

    public function save(Order $order): void
    {
        $this->entityRepository->getEntityManager()->persist($order);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Order $order): void
    {
        $this->entityRepository->getEntityManager()->remove($order);
        $this->entityRepository->getEntityManager()->flush();
    }
}
