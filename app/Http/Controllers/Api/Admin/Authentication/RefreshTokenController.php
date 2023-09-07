<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Authentication;

use App\Http\Requests\Admin\Auth\RefreshTokenRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Admin\Authentication\Application\Commands\RefreshToken\Command;
use Project\Domains\Admin\Authentication\Application\Commands\RefreshToken\CommandHandler;

final class RefreshTokenController
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
