<?php

namespace App\Http\Controllers\Api\Admin\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\CreateRoleRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Admin\Role\Application\Commands\Create\CreateRoleCommand;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class CreateRoleController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }

    public function __invoke(CreateRoleRequest $request): Response
    {
        $this->commandBus->dispatch(
            new CreateRoleCommand($request->get('value'), $request->get('permissions'), $request->get('is_active', true))
        );

        return $this->response->noContent(Response::HTTP_CREATED);
    }
}
