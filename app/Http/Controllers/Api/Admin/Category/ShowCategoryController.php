<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Category;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Admin\Product\Application\Queries\Categories\Find\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class ShowCategoryController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    ) {

    }

    public function __invoke(string $uuid): JsonResponse
    {
        $result = $this->queryBus->ask(
            new Query($uuid)
        );

        return $this->response->json($result);
    }
}
