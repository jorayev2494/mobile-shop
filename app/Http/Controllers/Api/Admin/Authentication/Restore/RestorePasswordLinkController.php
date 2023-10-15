<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Authentication\Restore;

use App\Http\Requests\Admin\Auth\Restore\RestorePasswordLinkRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Admin\Authentication\Application\Commands\RestorePasswordLink\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class RestorePasswordLinkController
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

        return $this->response->noContent();
    }
}
