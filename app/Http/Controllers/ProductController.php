<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collection\ProductCollectionResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Client\Product\Application\Queries\Find\FindProductQuery;
use Project\Domains\Client\Product\Application\Queries\Find\FindProductQueryHandler;
use Project\Domains\Client\Product\Application\Queries\Get\GetProductsQuery;
use Project\Domains\Client\Product\Application\Queries\Get\GetProductsQueryHandler;

class ProductController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
    )
    {
        
    }

    public function index(Request $request, GetProductsQueryHandler $handler): JsonResponse
    {
        $queryData = GetProductsQuery::makeFromRequest($request);
        $result = $handler($queryData);

        return $this->response->json(ProductCollectionResource::make($result));
    }

    public function show(FindProductQueryHandler $handler, string $uuid): JsonResponse
    {
        $queryData = new FindProductQuery($uuid);
        $result = $handler($queryData);

        return $this->response->json(ProductResource::make($result));
    }
}
