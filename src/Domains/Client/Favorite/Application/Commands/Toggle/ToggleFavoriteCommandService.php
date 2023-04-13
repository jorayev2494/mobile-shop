<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Commands\Toggle;

use App\Models\Client;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class ToggleFavoriteCommandService
{

    private readonly Client $client;

    public function __construct(
        private readonly AuthManagerInterface $authManager,
    )
    {
        $this->client = $authManager->client();
    }

    public function execute(ToggleFavoriteCommand $command): void
    {
        $this->client->favorites->contains($command->productUUID) ? $this->client->favorites()->detach($command->productUUID)
                                                                  : $this->client->favorites()->attach($command->productUUID);
    }
}
