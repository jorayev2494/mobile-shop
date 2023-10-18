<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Currency;

use App\Http\Requests\Admin\Currency\UpdateCurrencyRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Product\Application\Commands\Categories\Update\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\Response;

final class UpdateCurrencyController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(UpdateCurrencyRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $uuid,
                $request->get('value'),
                $request->get('is_active'),
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
