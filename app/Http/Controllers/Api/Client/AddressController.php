<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Address\UpdateAddressRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Project\Domains\Client\Address\Application\Commands\Delete\DeleteCommand;
use Project\Domains\Client\Address\Application\Commands\Delete\DeleteCommandHandler;
use Project\Domains\Client\Address\Application\Commands\Update\UpdateCommand;
use Project\Domains\Client\Address\Application\Commands\Update\UpdateCommandHandler;
use Project\Domains\Client\Address\Application\Queries\Find\FindAddressQuery;
use Project\Domains\Client\Address\Application\Queries\Find\FindAddressQueryHandler;

class AddressController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
    ) {

    }

    public function update(UpdateAddressRequest $request, UpdateCommandHandler $handler, string $uuid): JsonResponse
    {
        $command = UpdateCommand::from($request->validated() + compact('uuid'));
        $result = $handler($command);

        return $this->response->json($result, Response::HTTP_ACCEPTED);
    }

    public function destroy(DeleteCommandHandler $handler, string $uuid): Response
    {
        $command = DeleteCommand::from(compact('uuid'));
        $handler($command);

        return $this->response->noContent();
    }
}
