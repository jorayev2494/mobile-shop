<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Category;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\Client\Order\Application\Queries\Category\Index\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexCategoryController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    )
    {

    }

    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->queryBus->ask(
            Query::makeFromRequest($request),
        );

        return $this->response->json($result);
    }
}
