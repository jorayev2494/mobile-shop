<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Order;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Enums\AppGuardType;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Project\Domains\Client\Order\Application\Commands\Order\Create\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

class CreateOrderController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly AuthManagerInterface $authManager,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(StoreOrderRequest $request): JsonResponse
    {
        $this->commandBus->dispatch(
            new Command(
                $uuid = $this->uuidGenerator->generate(),
                $this->authManager->uuid(AppGuardType::CLIENT),
                $request->get('card_uuid'),
                $request->get('address_uuid'),
                $request->get('currency_uuid'),
                $request->get('products'),
                $request->get('email'),
                $request->get('phone'),
                $request->get('note'),
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }
}
