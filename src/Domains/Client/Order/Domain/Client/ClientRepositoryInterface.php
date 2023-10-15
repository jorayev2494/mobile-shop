<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain\Client;

use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid;

interface ClientRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Client;

    public function save(Client $client): void;
}
