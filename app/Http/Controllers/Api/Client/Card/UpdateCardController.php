<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Card;

use App\Http\Requests\Client\Card\UpdateCardRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Client\Order\Application\Commands\Card\Update\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class UpdateCardController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(UpdateCardRequest $request, string $uuid): Response
    {
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

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
