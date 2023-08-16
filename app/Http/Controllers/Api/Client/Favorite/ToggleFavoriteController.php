<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Favorite;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Client\Favorite\Application\Commands\Toggle\ToggleFavoriteCommand;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

class ToggleFavoriteController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
        private readonly AuthManagerInterface $authManager,
    )
    {
        
    }

    public function __invoke(string $productUUID): Response
    {
        $this->commandBus->dispatch(
            new ToggleFavoriteCommand($this->authManager->client()->uuid, $productUUID)
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
