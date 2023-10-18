<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure;

use phpcent\Client;
use Project\Infrastructure\Services\Authenticate\AuthenticatableInterface;

class CentrifugoClient
{
    private readonly Client $client;

    public function __construct(
        
    ) {
        $this->client = new Client(getenv('CENTRIFUGO_API_HOST'));
        $this->client->setApiKey(getenv('CENTRIFUGO_API_KEY'));
    }

    public function publish(string $channel, array $data): mixed
    {
        // $this->client->setApiKey(getenv('CENTRIFUGO_API_KEY'));

        return $this->client->publish($channel, $data);
    }

    public function generateAdminConnectionToken(string $uuid): string
    {
        return $this->client->generateConnectionToken($uuid, time() + 3600 * 12);
    }
}
