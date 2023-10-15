<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Product;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Client\Product\Application\Queries\Find\FindProductQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class ShowProductController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    ) {

    }

    public function __invoke(string $uuid): JsonResponse
    {
        $result = $this->queryBus->ask(
            new FindProductQuery($uuid)
        );

        return $this->response->json($result);
    }
}
