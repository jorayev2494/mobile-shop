<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Order;

use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Enums\AppGuardType;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Client\Order\Application\Commands\Order\Update\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

class UpdateOrderController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly AuthManagerInterface $authManager,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(UpdateOrderRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $uuid,
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

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
