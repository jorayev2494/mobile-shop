<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\CartProduct;

interface CartProductRepositoryInterface
{
    public function delete(CartProduct $cartProduct): void;
}
