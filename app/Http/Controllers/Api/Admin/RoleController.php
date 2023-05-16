<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Auth\AppAuth;
use App\Models\Auth\AuthModel;
use App\Models\Enums\AppGuardType;
use App\Services\Api\Admin\Contracts\RoleServiceInterface;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Project\Domains\Admin\Role\Application\Queries\ShowRole\ShowQuery;
use Project\Domains\Admin\Role\Application\Queries\ShowRole\ShowQueryHandler;
use Project\Domains\Admin\Role\Application\Commands\Create\CreateRoleCommand;
use Project\Domains\Admin\Role\Application\Commands\Create\CreateRoleCommandHandler;
use Project\Domains\Admin\Role\Application\Commands\Delete\DeleteRoleCommand;
use Project\Domains\Admin\Role\Application\Commands\Delete\DeleteRoleCommandHandler;
use Project\Domains\Admin\Role\Application\Commands\Update\UpdateRoleCommandHandler;
use Project\Domains\Admin\Role\Application\Queries\GetRoles\GetRolesQuery;
use Project\Domains\Admin\Role\Application\Queries\GetRoles\GetRolesQueryHandler;
use Project\Domains\Admin\Role\Application\Commands\Update\UpdateRoleCommand;

class RoleController extends Controller
{

    private readonly ?AuthModel $authModel;

    public function __construct(
        private readonly ResponseFactory $response,
        private readonly AuthManager $authManager,
        private readonly RoleServiceInterface $service,
    )
    {
        $this->authModel = AppAuth::model(AppGuardType::ADMIN) ?? Admin::factory()->make();
    }


    public function index(Request $request, GetRolesQueryHandler $getRolesQueryHandler): JsonResponse
    {
        $queryData = GetRolesQuery::makeFromRequest($request);
        $result = $getRolesQueryHandler($queryData);

        return $this->response->json($result);
    }

    public function store(Request $request, CreateRoleCommandHandler $createRoleCommandHandler): JsonResponse
    {
        $commandData = CreateRoleCommand::makeFromRequest($request);
        $result = $createRoleCommandHandler($commandData);

        return $this->response->json($result, Response::HTTP_CREATED);
    }

    public function show(ShowQueryHandler $showQueryHandler, int $id): JsonResponse
    {
        $commandData = new ShowQuery($id);
        $result = $showQueryHandler($commandData);

        return $this->response->json($result);
    }

    public function update(Request $request, UpdateRoleCommandHandler $updateRoleCommandHandler, int $id): JsonResponse
    {
        $commandData = new UpdateRoleCommand(
            $id,
            $request->get('value'),
            $request->boolean('is_active', true),
        );

        $result = $updateRoleCommandHandler($commandData);

        return $this->response->json($result, Response::HTTP_ACCEPTED);
    }

    public function destroy(DeleteRoleCommandHandler $deleteRoleCommandHandler, int $id): Response
    {
        $commandData = new DeleteRoleCommand($id);
        $deleteRoleCommandHandler($commandData);

        return $this->response->noContent();
    }
}
