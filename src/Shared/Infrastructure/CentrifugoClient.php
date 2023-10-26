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
        // $this->client = new Client(
        //     getenv('CENTRIFUGO_API_HOST'),
        //     getenv('CENTRIFUGO_API_KEY'),
        //     getenv('CENTRIFUGO_SECRET')
        // );

        // dd(
        //     getenv('CENTRIFUGO_API_HOST'),
        //     getenv('CENTRIFUGO_API_KEY'),
        //     getenv('CENTRIFUGO_SECRET')
        // );
        // $this->client->setApiKey(getenv('CENTRIFUGO_API_KEY'));

        $this->client = app()->make('centrifugo');
        // $this->client->setApiKey(getenv('CENTRIFUGO_API_KEY'));
        // $this->client->setSecret(getenv('CENTRIFUGO_SECRET'));
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
