<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Admin\Category\Application\Commands\Update\UpdateCategoryCommand;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class UpdateCategoryController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(UpdateCategoryRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new UpdateCategoryCommand($uuid, $request->get('value'), $request->boolean('is_active'))
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
