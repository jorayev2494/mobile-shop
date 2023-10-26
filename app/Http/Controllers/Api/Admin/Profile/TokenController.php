<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Profile;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Shared\Infrastructure\CentrifugoClient;
use Project\Utils\Auth\Contracts\AuthManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class TokenController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CentrifugoClient $centrifugoClient,
        private readonly AuthManagerInterface $authManager,
        // private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(): JsonResponse
    {
        $result = $this->centrifugoClient->generateAdminConnectionToken($this->authManager->admin()->uuid);

        return $this->response->json([
            'token' => $result,
        ]);
    }
}
