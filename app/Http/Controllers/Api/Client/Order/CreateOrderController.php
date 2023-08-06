<?php

namespace App\Http\Controllers\Api\Client\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Project\Domains\Client\Order\Application\Commands\Create\CreateOrderCommand;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class CreateOrderController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }
    
    public function __invoke(StoreOrderRequest $request): JsonResponse
    {
        $this->commandBus->dispatch(
            CreateOrderCommand::from($request->validated())
        );

        return $this->response->json([], Response::HTTP_CREATED);
    }
}
