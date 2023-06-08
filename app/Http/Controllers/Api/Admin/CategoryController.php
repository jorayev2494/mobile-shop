<?php

namespace App\Http\Controllers\Api\Admin;

use App\Data\Requests\IndexRequestDTO;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Auth\AppAuth;
use App\Models\Auth\AuthModel;
use App\Services\Api\Admin\Contracts\CategoryServiceInterface;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Project\Domains\Admin\Category\Application\Commands\Create\CreateCategoryCommand;
use Project\Domains\Admin\Category\Application\Commands\Create\CreateCategoryCommandHandler;
use Project\Domains\Admin\Category\Application\Commands\Delete\DeleteCategoryCommand;
use Project\Domains\Admin\Category\Application\Commands\Delete\DeleteCategoryCommandHandler;
use Project\Domains\Admin\Category\Application\Commands\Update\UpdateCategoryCommand;
use Project\Domains\Admin\Category\Application\Commands\Update\UpdateCategoryCommandHandler;
use Project\Domains\Admin\Category\Application\Queries\Find\FindCategoryQuery;
use Project\Domains\Admin\Category\Application\Queries\Find\FindCategoryQueryHandler;
use Project\Domains\Admin\Category\Application\Queries\Get\GetCategoriesQuery;
use Project\Domains\Admin\Category\Application\Queries\Get\GetCategoriesQueryHandler;

class CategoryController extends Controller
{

    private readonly ?AuthModel $authModel;

    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CategoryServiceInterface $service,
    )
    {
        $this->authModel = AppAuth::model() ?? Admin::factory()->make();
    }

    // public function store(Request $request, CreateCategoryCommandHandler $handler): JsonResponse
    // {
    //     $query = new CreateCategoryCommand($request->get('value'), $request->boolean('is_active', true));
    //     $result = $handler($query);

    //     return $this->response->json($result, Response::HTTP_CREATED);
    // }

    // public function show(FindCategoryQueryHandler $handler, string $uuid): JsonResponse
    // {
    //     $query = new FindCategoryQuery($uuid);
    //     $result = $handler($query);

    //     return $this->response->json($result);
    // }

    // public function update(Request $request, UpdateCategoryCommandHandler $handler, string $uuid): JsonResponse
    // {
    //     $query = new UpdateCategoryCommand($uuid, $request->get('value'), $request->boolean('is_active'));
    //     $result = $handler($query);

    //     return $this->response->json($result, Response::HTTP_ACCEPTED);
    // }

    // public function destroy(DeleteCategoryCommandHandler $handler, string $uuid): Response
    // {
    //     $query = new DeleteCategoryCommand($uuid);
    //     $handler($query);

    //     return $this->response->noContent();
    // }
}
