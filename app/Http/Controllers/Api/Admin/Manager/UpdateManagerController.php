<?php

namespace App\Http\Controllers\Api\Admin\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Manager\UpdateManagerRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Project\Domains\Admin\Manager\Application\Commands\Update\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

class UpdateManagerController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    )
    {
        
    }
    
    public function __invoke(UpdateManagerRequest $request, string $uuid): Response
    {
        $this->commandBus->dispatch(
            new Command(
                $uuid,
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('email'),
                $request->integer('role_id'),
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
