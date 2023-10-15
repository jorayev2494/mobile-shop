<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Client;

use App\Http\Requests\Admin\Client\UpdateClientRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Admin\Client\Application\Commands\Update\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class UpdateClientController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    ) {

    }


    public function __invoke(UpdateClientRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $uuid,
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('email'),
                $request->get('phone'),
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
