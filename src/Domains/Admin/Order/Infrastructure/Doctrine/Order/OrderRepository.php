<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Infrastructure\Doctrine\Order;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Order\Domain\Order\Order;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;
use Project\Domains\Admin\Order\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\StatusEnum;
use Project\Shared\Application\Query\BaseQuery;

final class OrderRepository extends BaseClientEntityRepository implements OrderRepositoryInterface
{
    protected function getEntity(): string
    {
        return Order::class;
    }

    public function findByUuid(Uuid $uuid): ?Order
    {
        return $this->entityRepository->find($uuid);
    }

    public function paginateByStatus(BaseQuery $queryData, ?StatusEnum $status): Paginator
    {
        $query = $this->entityRepository->createQueryBuilder('o');

        if ($status !== null) {
            $query->where('o.status = :status')
                ->setParameter('status', $status);
        }
                                        
        $query->getQuery();

        return $this->paginator($query, $queryData);
    }

    public function save(Order $order): void
    {
        $this->entityRepository->getEntityManager()->persist($order);
        $this->entityRepository->getEntityManager()->flush();
    }
}
