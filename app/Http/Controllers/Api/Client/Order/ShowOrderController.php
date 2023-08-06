<?php

namespace App\Http\Controllers\Api\Client\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Client\Order\Application\Queries\Find\FindOrderQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class ShowOrderController extends Controller
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
            new FindOrderQuery($uuid)
        );

        return $this->response->json(OrderResource::make($result));
    }
}
