<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Address;

use App\Http\Requests\Client\Address\StoreAddressRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Client\Order\Application\Commands\Address\Create\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class CreateAddressController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator,
    ) {

    }

    public function __invoke(StoreAddressRequest $request): Response
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new Command(
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

        return $this->response->noContent(Response::HTTP_CREATED);
    }
}
