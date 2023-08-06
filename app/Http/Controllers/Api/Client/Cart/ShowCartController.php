<?php

namespace App\Http\Controllers\Api\Client\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Client\Cart\Application\Queries\Show\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class ShowCartController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private QueryBusInterface $queryBus,
    )
    {
        
    }

    public function __invoke(string $uuid): JsonResponse
    {
        $result = $this->queryBus->ask(
            new Query($uuid)
        );

        return $this->response->json($result);
    }
}
