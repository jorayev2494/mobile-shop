<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Authentication;

use App\Http\Requests\Admin\Auth\LoginRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Admin\Authentication\Application\Commands\Login\Command;
use Project\Domains\Admin\Authentication\Application\Commands\Login\CommandHandler;

class LoginController
{
    public function __construct(
        private readonly ResponseFactory $response,
    )
    {
        
    }

    public function __invoke(LoginRequest $request, CommandHandler $handler): JsonResponse
    {
        $result = $handler(
            new Command(
                $request->get('email'),
                $request->get('password'),
                $request->headers->get('x-device-id')
            )
        );

        return $this->response->json($result);
    }
}
