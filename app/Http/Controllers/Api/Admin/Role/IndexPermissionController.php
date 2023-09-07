<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Role;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Admin\Role\Application\Queries\GetPermissions\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class IndexPermissionController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    ) {

    }

    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->queryBus->ask(
            Query::makeFromRequest($request)
        );

        return $this->response->json($result);
    }
}
