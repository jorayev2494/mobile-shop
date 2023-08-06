<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Cart;

use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartUUID;

interface CartRepositoryInterface extends BaseModelRepositoryInterface
{
    public function findByUUID(CartUUID $uuid): ?Cart;
    public function save(Cart $cart): void;

    public function delete(CartUUID $uuid): void;
}
