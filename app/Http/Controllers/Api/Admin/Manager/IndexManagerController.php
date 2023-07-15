<?php

namespace App\Http\Controllers\Api\Admin\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Admin\Manager\Application\Queries\Index\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class IndexManagerController extends Controller
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
            Query::makeFromRequest($request)
        );

        return $this->response->json($result);
    }
}
