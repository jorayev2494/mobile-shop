<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Domain\Customer;

;
use Project\Domains\Client\Delivery\Domain\Customer\ValueObjects\Uuid;

interface CustomerRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Customer;

    public function save(Customer $customer): void;
}
