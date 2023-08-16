<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Address;

use App\Http\Requests\Client\Address\UpdateAddressRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Client\Address\Application\Commands\Update\UpdateCommand;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class UpdateAddressController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function __invoke(UpdateAddressRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new UpdateCommand(
                $uuid,
                $request->get('title'),
                $request->get('full_name'),
                $request->get('first_address'),
                $request->get('second_address'),
                $request->get('zip_code'),
                $request->get('country_uuid'),
                $request->get('city_uuid'),
                $request->get('district'),
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
