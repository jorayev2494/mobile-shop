<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Card\StoreCardRequest;
use App\Http\Requests\Client\Card\UpdateCardRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Project\Domains\Client\Card\Application\Commands\Create\CreateCardCommand;
use Project\Domains\Client\Card\Application\Commands\Create\CreateCardCommandHandler;
use Project\Domains\Client\Card\Application\Commands\Delete\DeleteCardCommand;
use Project\Domains\Client\Card\Application\Commands\Delete\DeleteCardCommandHandler;
use Project\Domains\Client\Card\Application\Commands\Update\UpdateCardCommand;
use Project\Domains\Client\Card\Application\Commands\Update\UpdateCardCommandHandler;
use Project\Domains\Client\Card\Application\Queries\Find\FindCardQuery;
use Project\Domains\Client\Card\Application\Queries\Find\FindCardQueryHandler;
use Project\Domains\Client\Card\Application\Queries\GetCards\GetCardsQuery;
use Project\Domains\Client\Card\Application\Queries\GetCards\GetCardsQueryHandler;

class CardController extends Controller
{

    public function __construct(
        private readonly ResponseFactory $response,
    )
    {
        
    }


    public function index(Request $request, GetCardsQueryHandler $handler): JsonResponse
    {
        $query = GetCardsQuery::makeFromRequest($request);
        $result = $handler($query);

        return $this->response->json($result);
    }

    public function store(StoreCardRequest $request, CreateCardCommandHandler $handler): JsonResponse
    {
        $command = CreateCardCommand::from($request->validated());
        $result = $handler($command);

        return $this->response->json($result, Response::HTTP_CREATED);
    }

    public function show(FindCardQueryHandler $handler, string $uuid): JsonResponse
    {
        $query = FindCardQuery::from(compact('uuid'));
        $result = $handler($query);

        return $this->response->json($result);
    }

    public function update(UpdateCardRequest $request, UpdateCardCommandHandler $handler, string $uuid): JsonResponse
    {
        $command = UpdateCardCommand::from($request->validated() + compact('uuid'));
        $result = $handler($command);

        return $this->response->json($result, Response::HTTP_ACCEPTED);
    }

    public function destroy(DeleteCardCommandHandler $handler, string $uuid): Response
    {
        $command = DeleteCardCommand::from(compact('uuid'));
        $handler($command);

        return $this->response->noContent();
    }
}
