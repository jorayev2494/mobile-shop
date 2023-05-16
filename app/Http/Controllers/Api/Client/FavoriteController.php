<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collection\ProductCollectionResource;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Project\Domains\Client\Favorite\Application\Commands\Toggle\ToggleFavoriteCommand;
use Project\Domains\Client\Favorite\Application\Commands\Toggle\ToggleFavoriteCommandHandler;
use Project\Domains\Client\Favorite\Application\Queries\Get\GetFavoritesQuery;
use Project\Domains\Client\Favorite\Application\Queries\Get\GetFavoritesQueryHandler;

class FavoriteController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
    )
    {
        
    }

    public function index(Request $request, GetFavoritesQueryHandler $handler): JsonResponse
    {
        $queryData = GetFavoritesQuery::makeFromRequest($request);
        $result = $handler($queryData);

        return $this->response->json(ProductCollectionResource::make($result));
    }

    public function toggle(ToggleFavoriteCommandHandler $handler, string $productUUID): Response
    {
        $commandData = ToggleFavoriteCommand::from(compact('productUUID'));
        $handler($commandData);

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
