<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Infrastructure\Doctrine\OrderProduct;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Order\Domain\OrderProduct\OrderProduct;
use Project\Domains\Client\Order\Domain\OrderProduct\OrderProductRepositoryInterface;

final class OrderProductRepository extends BaseClientEntityRepository implements OrderProductRepositoryInterface
{
    protected function getEntity(): string
    {
        return OrderProduct::class;
    }

    public function delete(OrderProduct $orderProduct): void
    {
        $this->entityRepository->getEntityManager()->remove($orderProduct);
        $this->entityRepository->getEntityManager()->flush();
    }
}
