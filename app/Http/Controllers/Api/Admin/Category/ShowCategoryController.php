<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Admin\Category\Application\Queries\Find\FindCategoryQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class ShowCategoryController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    ) {

    }

    public function __invoke(string $uuid): JsonResponse
    {
        $result = $this->queryBus->ask(
            new FindCategoryQuery($uuid)
        );

        return $this->response->json($result);
    }
}
