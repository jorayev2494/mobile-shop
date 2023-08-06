<?php

namespace App\Http\Controllers\Api\Client\Order;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Client\Order\Application\Queries\Get\GetOrdersQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class IndexOrderController extends Controller
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
            GetOrdersQuery::makeFromRequest($request)
        );

        return $this->response->json($result);
    }
}
