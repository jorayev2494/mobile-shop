<?php

namespace App\Http\Controllers\Api\Admin\Country;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Country\UpdateCountryRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Project\Domains\Admin\Country\Application\Commands\Update\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class UpdateCountryController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function __invoke(UpdateCountryRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new Command($uuid, $request->get('value'), $request->get('iso'), $request->get('is_active'))
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
