<?php

namespace App\Http\Controllers\Api\Admin\Role;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Admin\Role\Application\Queries\ShowRole\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class ShowRoleController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    )
    {
        
    }
    public function __invoke(int $id): JsonResponse
    {
        $role = $this->queryBus->ask(
            new Query($id)
        );

        return $this->response->json($role);
    }
}
