<?php

namespace App\Http\Controllers\Api\Client\Cart;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Client\Cart\Application\Commands\Operator\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\Response;

class OperatorCartProductController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function __invoke(Request $request, string $productUuid): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $productUuid,
                $request->get('operator'),
                $request->get('operator_value'),
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
