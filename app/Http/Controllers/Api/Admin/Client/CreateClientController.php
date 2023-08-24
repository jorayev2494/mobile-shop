<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Client;

use App\Http\Requests\Admin\Client\CreateClientRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Project\Domains\Admin\Client\Application\Commands\Create\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class CreateClientController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator,
    )
    {
        
    }

    public function __invoke(CreateClientRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new Command(
                $uuid,
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('email'),
                $request->get('phone')
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_ACCEPTED);
    }
}
