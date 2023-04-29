<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Project\Domains\Client\Order\Application\Commands\Create\CreateOrderCommand;
use Project\Domains\Client\Order\Application\Commands\Create\CreateOrderCommandHandler;
use Project\Domains\Client\Order\Application\Commands\Delete\DeleteOrderCommand;
use Project\Domains\Client\Order\Application\Commands\Delete\DeleteOrderCommandHandler;
use Project\Domains\Client\Order\Application\Commands\Update\UpdateOrderCommand;
use Project\Domains\Client\Order\Application\Commands\Update\UpdateOrderCommandHandler;
use Project\Domains\Client\Order\Application\Queries\Find\FindOrderQuery;
use Project\Domains\Client\Order\Application\Queries\Find\FindOrderQueryHandler;
use Project\Domains\Client\Order\Application\Queries\Get\GetOrdersQuery;
use Project\Domains\Client\Order\Application\Queries\Get\GetOrdersQueryHandler;

class OrderController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
    )
    {
        
    }

    public function index(Request $request, GetOrdersQueryHandler $handler): JsonResponse
    {
        $queryData = GetOrdersQuery::makeFromRequest($request);
        $result = $handler($queryData);

        return $this->response->json($result);
    }

    public function store(StoreOrderRequest $request, CreateOrderCommandHandler $handler): JsonResponse
    {
        $queryData = CreateOrderCommand::from($request->validated());
        $result = $handler($queryData);

        return $this->response->json($result, Response::HTTP_CREATED);
    }

    public function show(FindOrderQueryHandler $handler, string $uuid): JsonResponse
    {
        $queryData = new FindOrderQuery($uuid);
        $result = $handler($queryData);

        return $this->response->json(OrderResource::make($result));
    }

    public function update(UpdateOrderRequest $request, UpdateOrderCommandHandler $handler, string $uuid): JsonResponse
    {
        $commandData = UpdateOrderCommand::from(compact('uuid') + $request->validated());
        $result = $handler($commandData);

        return $this->response->json($result, Response::HTTP_ACCEPTED);
    }

    public function destroy(DeleteOrderCommandHandler $handler, string $uuid): Response
    {
        $handler(DeleteOrderCommand::from(compact('uuid')));

        return $this->response->noContent();
    }
}
