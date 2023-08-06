<?php

namespace App\Http\Controllers\Api\Client\Card;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Client\Card\Application\Commands\Delete\DeleteCardCommand;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class DeleteCardController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function __invoke(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new DeleteCardCommand($uuid)
        );

        return $this->response->noContent();
    }
}
