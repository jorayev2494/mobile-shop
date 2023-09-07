<?php

namespace App\Http\Controllers\Api\Client\Authentication;

use App\Http\Requests\Client\Auth\RefreshTokenRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Client\Authentication\Application\Commands\RefreshToken\Command;
use Project\Domains\Client\Authentication\Application\Commands\RefreshToken\CommandHandler;

class RefreshTokenController
{
    public function __construct(
        private readonly ResponseFactory $response,
    )
    {
        
    }

    public function __invoke(RefreshTokenRequest $request, CommandHandler $handler): JsonResponse
    {
        $result = $handler(
            new Command(
                $request->get('refresh_token'),
                $request->headers->get('x-device-id')
            )
        );

        return $this->response->json($result);
    }
}
