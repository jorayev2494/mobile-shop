<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Cart;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Client\Cart\Application\Queries\Show\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class ShowCartController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private QueryBusInterface $queryBus,
    )
    {
        
    }

    public function __invoke(string $uuid): JsonResponse
    {
        $result = $this->queryBus->ask(
            new Query($uuid)
        );

        // dd($result);

        return $this->response->json($result);
    }
}
