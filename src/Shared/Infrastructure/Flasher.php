<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure;

use Project\Shared\Domain\FlasherInterface;

class Flasher implements FlasherInterface
{
    
    public function __construct(
        private readonly CentrifugoClient $client,
    ) {
        
    }

    public function publish(string $channel, array $data, string $type = 'success'): mixed
    {
        return $this->client->publish($channel, [ ...$data, ...compact('type') ]);
    }
}
