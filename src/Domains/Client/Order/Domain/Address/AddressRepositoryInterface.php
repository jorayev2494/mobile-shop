<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Address;

use Project\Domains\Client\Order\Domain\Address\Address;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid;

interface AddressRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Address;
    public function save(Address $address): void;
    public function delete(Address $address): void;
}
