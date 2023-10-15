<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Favorite;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Client\Favorite\Application\Queries\Get\GetFavoritesQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class IndexFavoriteController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    ) {

    }

    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->queryBus->ask(
            GetFavoritesQuery::makeFromRequest($request)
        );

        return $this->response->json($result);
    }
}
