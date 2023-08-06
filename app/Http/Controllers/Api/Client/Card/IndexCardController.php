<?php

namespace App\Http\Controllers\Api\Client\Card;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Client\Card\Application\Queries\GetCards\GetCardsQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class IndexCardController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    )
    {
        
    }


    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->queryBus->ask(
            GetCardsQuery::makeFromRequest($request)
        );

        return $this->response->json($result);
    }
}
