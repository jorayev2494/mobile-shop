<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Infrastructure\Doctrine\Cart;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Cart\Domain\Cart\Cart;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\AuthorUuid;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\ClientUuid;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\Uuid;

final class CartRepository extends BaseClientEntityRepository implements CartRepositoryInterface
{
    protected function getEntity(): string
    {
        return Cart::class;
    }

    public function findByUuid(Uuid $uuid): ?Cart
    {
        return $this->entityRepository->find($uuid);
    }

    public function findCartByAuthorUuid(AuthorUuid $authorUuid): ?Cart
    {
        return $this->entityRepository->findOneBy(['authorUuid' => $authorUuid]);
    }

    public function save(Cart $cart): void
    {
        $this->entityRepository->getEntityManager()->persist($cart);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Cart $cart): void
    {
        $this->entityRepository->getEntityManager()->remove($cart);
        $this->entityRepository->getEntityManager()->flush();
    }
}
