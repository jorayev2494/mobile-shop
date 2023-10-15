<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Cart;

use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\Uuid;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\AuthorUuid;

interface CartRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Cart;

    public function findCartByAuthorUuid(AuthorUuid $authorUuid): ?Cart;

    public function save(Cart $cart): void;

    public function delete(Cart $cart): void;
}
