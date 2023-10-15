<?php

namespace App\Http\Controllers\Api\Admin\Country;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Admin\Country\Application\Commands\Delete\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class DeleteCountryController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }
    public function __invoke(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new Command($uuid)
        );

        return $this->response->noContent();
    }
}
