<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Project\Domains\Admin\Product\Application\Commands\Categories\Delete\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class DeleteCategoryController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(string $uuid): Response
    {
        $this->commandBus->dispatch(
            new Command($uuid)
        );

        return $this->response->noContent();
    }
}
