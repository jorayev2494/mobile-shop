<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Card;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Client\Card\Application\Queries\Find\FindCardQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class ShowCardController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    )
    {
        
    }

    public function __invoke(string $uuid): JsonResponse
    {
        $result = $this->queryBus->ask(
            new FindCardQuery($uuid)
        );

        return $this->response->json($result);
    }
}
