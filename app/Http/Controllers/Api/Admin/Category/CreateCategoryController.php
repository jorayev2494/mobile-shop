<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Project\Domains\Admin\Product\Application\Commands\Categories\Create\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class CreateCategoryController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(CreateCategoryRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new Command(
                $uuid,
                $request->get('value'),
                $request->boolean('is_active', true)
            )
        );

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }
}
