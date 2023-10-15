<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Authentication;

use App\Http\Requests\Admin\Auth\RegisterRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Admin\Authentication\Application\Commands\Register\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class RegisterController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(RegisterRequest $request): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('email'),
                $request->get('password'),
                $request->get('agree_with_privacy'),
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
