<?php

namespace App\Http\Controllers\Api\Admin;

use App\Data\Requests\IndexRequestDTO;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Auth\AppAuth;
use App\Models\Auth\AuthModel;
use App\Models\Enums\AppGuardType;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Project\Domains\Admin\Product\Application\Queries\Find\FindProductQuery;
use Project\Domains\Admin\Product\Application\Queries\Find\FindProductQueryHandler;
use Project\Domains\Admin\Product\Application\Queries\Get\GetProductsQuery;
use Project\Domains\Admin\Product\Application\Queries\Get\GetProductsQueryHandler;
use Project\Domains\Admin\Product\Application\Commands\Create\CreateProductCommandHandler;
use Project\Domains\Admin\Product\Application\Commands\Create\CreateProductCommand;
use Project\Domains\Admin\Product\Application\Commands\Delete\DeleteProductCommand;
use Project\Domains\Admin\Product\Application\Commands\Delete\DeleteProductCommandHandler;
use Project\Domains\Admin\Product\Application\Commands\Update\UpdateProductCommand;
use Project\Domains\Admin\Product\Application\Commands\Update\UpdateProductCommandHandler;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class ProductController extends Controller
{

    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator,
    )
    {
        
    }

    public function index(Request $request, GetProductsQueryHandler $handler): JsonResponse
    {
        $queryData = GetProductsQuery::makeFromRequest($request);
        $result = $handler($queryData);

        return $this->response->json($result);
    }

    public function store(Request $request): JsonResponse
    {
        $uuid = $request->get('uuid', $this->uuidGenerator->generate());

        $commandData = new CreateProductCommand(
            $uuid,
            $request->get('title'),
            $request->get('category_uuid'),
            $request->get('currency_uuid'),
            $request->get('price'),
            $request->get('discount_presence'),
            $request->file('medias'),
            $request->get('description'),
            $request->get('is_active', true),
        );

        $this->commandBus->dispatch($commandData);

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }

    public function show(FindProductQueryHandler $handler, string $uuid): JsonResponse
    {
        $queryData = new FindProductQuery($uuid);
        $result = $handler($queryData);

        return $this->response->json($result);
    }

    public function update(Request $request, UpdateProductCommandHandler $handler, string $uuid): JsonResponse
    {
        $commandData = new UpdateProductCommand(
            $uuid,
            $request->get('title'),
            $request->get('category_uuid'),
            $request->get('currency_uuid'),
            $request->get('price'),
            $request->get('discount_presence'),
            $request->get('description'),
            $request->get('is_active'),
        );

        $result = $handler($commandData);

        return $this->response->json($result, Response::HTTP_ACCEPTED);
    }

    public function destroy(DeleteProductCommandHandler $handler, string $uuid): Response
    {
        $commandData = new DeleteProductCommand($uuid);
        $handler($commandData);

        return $this->response->noContent();
    }
}
