<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Product;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Admin\Product\Application\Queries\Find\FindProductQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

final class ShowProductController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    )
    {
        
    }

    public function __invoke(string $uuid): JsonResponse
    {
        $result = $this->queryBus->ask(
            new FindProductQuery($uuid)
        );

        return $this->response->json($result);
    }
}