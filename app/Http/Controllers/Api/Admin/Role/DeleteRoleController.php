<?php

namespace App\Http\Controllers\Api\Admin\Role;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Admin\Role\Application\Commands\Delete\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class DeleteRoleController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function __invoke(int $id): Response
    {
        $this->commandBus->dispatch(
            new Command($id)
        );

        return $this->response->noContent();
    }
}
