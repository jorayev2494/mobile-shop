<?php

namespace App\Http\Controllers\Api\Client\Cart;

use App\Http\Requests\Client\Cart\CreateCartRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Client\Cart\Application\Commands\Create\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class CreateCartController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function __invoke(CreateCartRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new Command($uuid, $request->get('products'))
        );

        return $this->response->json(['uuid' => $uuid]);
    }
}
