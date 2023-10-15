<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Cart;

use App\Http\Requests\Client\Cart\DeleteProductRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Client\Cart\Application\Commands\DeleteProduct\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class DeleteProductFromCartController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(DeleteProductRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $request->get('product_uuid'),
            )
        );

        return $this->response->noContent(Response::HTTP_NO_CONTENT);
    }
}
