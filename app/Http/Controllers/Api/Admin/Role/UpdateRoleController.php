<?php

namespace App\Http\Controllers\Api\Admin\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Project\Domains\Admin\Role\Application\Commands\Update\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class UpdateRoleController extends Controller
{

    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function __invoke(UpdateRoleRequest $request, int $id): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $id,
                $request->get('value'),
                $request->get('permissions')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
