<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure;

use Project\Shared\Domain\AbstractFlasher;

class Flasher extends AbstractFlasher
{
    
    public function __construct(
        private readonly CentrifugoClient $client,
    ) {
        
    }

    public function publish(string $channel, array $data): mixed
    {
        return $this->client->publish($channel, $data);
    }
}
