<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Shared\Domain\DomainException;
use Project\Shared\Infrastructure\Flasher;
use Symfony\Component\HttpFoundation\JsonResponse;

class TestController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly Flasher $flasher,
    ) {
        
    }

    public function __invoke(string $method): JsonResponse
    {
        $result = method_exists($this, $method) ? $this->$method(): throw new DomainException('The method wasn\'t found!' );

        return $this->response->json($result);
    }

    private function centrifugo(): JsonResponse
    {
        $channel = 'alerts';
        $data = [
            'message' => 'Hello world! from PHP',
        ];

        $channel .= '#fc5175e5-c066-4b52-a10b-148baee83365';
        
        $result = $this->flasher->publish($channel, $data);

        return $this->response->json($result);
    }
}
