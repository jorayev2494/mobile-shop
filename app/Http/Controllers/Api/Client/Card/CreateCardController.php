<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Card;

use App\Http\Requests\Client\Card\StoreCardRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Project\Domains\Client\Card\Application\Commands\Create\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class CreateCardController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(StoreCardRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new Command(
                $uuid,
                $request->get('type'),
                $request->get('holder_name'),
                $request->get('number'),
                $request->get('cvv'),
                $request->get('expiration_date'),
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }
}
