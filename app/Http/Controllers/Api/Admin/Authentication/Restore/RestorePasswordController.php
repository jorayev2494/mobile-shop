<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Authentication\Restore;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Http\Requests\Admin\Auth\Restore\RestorePasswordRequest;
use Project\Domains\Admin\Authentication\Application\Commands\RestorePassword\Command;

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
            new Command($request->get('token'), $request->get('password'))
        );

        return $this->response->noContent();
    }
}
