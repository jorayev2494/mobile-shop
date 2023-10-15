<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Infrastructure\Doctrine\CartProduct;
use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Cart\Domain\CartProduct\CartProduct;
use Project\Domains\Client\Cart\Domain\CartProduct\CartProductRepositoryInterface;

final class CartProductRepository extends BaseClientEntityRepository implements CartProductRepositoryInterface
{
    protected function getEntity(): string
    {
        return CartProduct::class;
    }

    public function delete(CartProduct $cartProduct): void
    {
        $this->entityRepository->getEntityManager()->remove($cartProduct);
        $this->entityRepository->getEntityManager()->flush();
    }
}
