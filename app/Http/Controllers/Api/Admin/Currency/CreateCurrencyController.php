<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Currency;

use App\Http\Requests\Admin\Currency\CreateCurrencyRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Product\Application\Commands\Categories\Create\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CreateCurrencyController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(CreateCurrencyRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new Command(
                $uuid,
                $request->get('value'),
                $request->get('is_active')
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }
}
