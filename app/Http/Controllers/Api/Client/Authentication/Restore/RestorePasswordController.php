<?php

namespace App\Http\Controllers\Api\Client\Authentication\Restore;

use App\Http\Requests\Client\Auth\Restore\RestorePasswordRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Project\Domains\Client\Authentication\Application\Commands\RestorePassword\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class RestorePasswordController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function __invoke(RestorePasswordRequest $request): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $request->get('code'),
                $request->get('password')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
