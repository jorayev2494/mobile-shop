<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Product;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Client\Product\Application\Queries\Get\GetProductsQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class IndexProductController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    ) {

    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var LengthAwarePaginator $result */
        $result = $this->queryBus->ask(GetProductsQuery::makeFromRequest($request));

        return $this->response->json($result);
    }
}
