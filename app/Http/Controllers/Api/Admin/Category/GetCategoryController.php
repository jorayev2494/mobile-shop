<?php

namespace App\Http\Controllers\Api\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Admin\Category\Application\Queries\Get\GetCategoriesQuery;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class GetCategoryController extends Controller
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
            GetCategoriesQuery::makeFromRequest($request)
        );

        return $this->response->json($result);
    }
}
