<?php

namespace App\Http\Controllers\Api\Admin\Role;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Admin\Role\Application\Queries\ShowRole\ShowQuery;
use Project\Domains\Admin\Role\Domain\Role;
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
        /** @var Role $role */
        $role = $this->queryBus->ask(
            new ShowQuery($id)
        );

        $permissions = array_map(
            static function (array $permission): array {
                unset($permission['pivot']);

                return $permission;
            },
            $role->permissions
        );

        $role->setPermissions($permissions);

        return $this->response->json($role);
    }
}
