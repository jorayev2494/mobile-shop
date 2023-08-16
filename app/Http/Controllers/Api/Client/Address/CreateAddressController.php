<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Address;

use App\Http\Requests\Client\Address\StoreAddressRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Client\Address\Application\Commands\Create\CreateCommand;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class CreateAddressController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function __invoke(StoreAddressRequest $request): Response
    {
        $this->commandBus->dispatch(
            new CreateCommand(
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

        return $this->response->noContent(Response::HTTP_CREATED);
    }
}
