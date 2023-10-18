<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Currency;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Product\Application\Commands\Categories\Delete\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\Response;

class DeleteCurrencyController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new Command($uuid)
        );

        return $this->response->noContent();
    }
}
