<?php

declare(strict_types=1);

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
    ) {

    }

    public function __invoke(AddProductRequest $request): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $request->get('product_uuid'),
                $request->get('quantity'),
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
