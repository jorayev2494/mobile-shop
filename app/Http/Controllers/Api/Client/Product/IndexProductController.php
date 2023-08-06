<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Collection\ProductCollectionResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Client\Product\Application\Queries\Get\GetProductsQuery;
use Project\Domains\Client\Product\Application\Queries\Get\GetProductsQueryHandler;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class IndexProductController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    )
    {
        
    }

    public function __invoke(Request $request): JsonResponse
    {
        // dd($request->all());
        /** @var LengthAwarePaginator $result */
        $result = $this->queryBus->ask(GetProductsQuery::makeFromRequest($request));

        // return $this->response->json($result);
        return $this->response->json(ProductCollectionResource::make($result));
        // return new TestResponse('Alex', 'Petrov');
    }
}
