<?php

namespace App\Http\Controllers\Api\Client\Cart;

use App\Http\Requests\Client\Cart\AddProductRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Client\Cart\Application\Commands\AddProduct\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class AddProductController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function __invoke(AddProductRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $uuid,
                $request->get('product_uuid'),
                $request->get('product_currency_uuid'),
                $request->get('product_quality'),
                $request->get('product_price'),
                $request->get('product_discount_percentage'),
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
