<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Authentication;

use App\Http\Requests\Client\Auth\RegisterRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Project\Domains\Client\Authentication\Application\Commands\Register\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class RegisterController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator,
    ) {

    }

    public function __invoke(RegisterRequest $request): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('email'),
                $request->get('password')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
