<?php

namespace App\Http\Controllers\Api\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Order\UpdateOrderRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Admin\Order\Application\Commands\Update\UpdateOrderCommand;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class UpdateOrderController extends Controller
{

    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }
    
    public function __invoke(UpdateOrderRequest $request): Response
    {
        dd($request);
        dd(
            new UpdateOrderCommand(
                $request->get('uuid'),
                $request->get('email'),
                $request->get('phone'),
                $request->get('description'),
                $request->get('status')
            )
        );
        // $this->commandBus->dispatch(
            
        // );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
