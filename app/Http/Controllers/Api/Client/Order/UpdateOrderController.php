<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Order;

use App\Http\Requests\Order\UpdateOrderRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Client\Order\Application\Commands\Update\UpdateOrderCommand;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class UpdateOrderController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }
    
    public function __invoke(UpdateOrderRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            UpdateOrderCommand::from(compact('uuid') + $request->validated())
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
