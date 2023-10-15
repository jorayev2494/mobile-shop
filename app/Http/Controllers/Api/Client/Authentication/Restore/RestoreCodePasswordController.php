<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Authentication\Restore;

use App\Http\Requests\Client\Auth\Restore\RestorePasswordLinkRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Client\Authentication\Application\Commands\RestorePasswordCode\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class RestoreCodePasswordController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(RestorePasswordLinkRequest $request): Response
    {
        $this->commandBus->dispatch(
            new Command($request->get('email'))
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
