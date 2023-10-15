<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Client;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Admin\Client\Application\Delete\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class DeleteClientController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new Command($uuid)
        );

        return $this->response->noContent();
    }
}
