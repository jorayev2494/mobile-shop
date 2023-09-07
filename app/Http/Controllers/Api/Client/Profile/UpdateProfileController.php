<?php

namespace App\Http\Controllers\Api\Client\Profile;

use App\Http\Requests\Client\Profile\UpdateProfileRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Project\Domains\Client\Profile\Application\Commands\Update\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class UpdateProfileController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function __invoke(UpdateProfileRequest $request): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('email'),
                $request->get('phone'),
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
