<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Cart;

use App\Http\Requests\Client\Cart\ConfirmRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Client\Cart\Application\Commands\Confirm\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class ConfirmController
{

    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function __invoke(ConfirmRequest $request): Response
    {
        info(__METHOD__, $request->validated());
        $this->commandBus->dispatch(
            new Command(
                $request->get('card_uuid'),
                $request->get('address_uuid'),

                $request->get('currency_uuid'),
                $request->get('email'),
                $request->get('phone'),

                $request->get('promo_code'),
                $request->get('note'),
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
