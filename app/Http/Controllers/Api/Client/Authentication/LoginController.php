<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Authentication;

use App\Http\Requests\Client\Auth\LoginRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Client\Authentication\Application\Commands\Login\Command;
use Project\Domains\Client\Authentication\Application\Commands\Login\CommandHandler;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

final class LoginController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(LoginRequest $request, CommandHandler $handler): JsonResponse
    {
        $result = $handler(
            new Command(
                $request->get('email'),
                $request->get('password'),
                $request->headers->get('x-device-id'),
            )
        );

        return $this->response->json($result);
    }
}
