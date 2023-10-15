<?php

namespace App\Http\Controllers\Api\Admin\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Manager\CreateManagerRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Admin\Manager\Application\Commands\Create\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class CreateManagerController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator,
    )
    {
        
    }
    
    public function __invoke(CreateManagerRequest $request): JsonResponse
    {
        $uuid = $this->uuidGenerator->generate();

        $this->commandBus->dispatch(
            new Command(
                $uuid,
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('email'),
                $request->integer('role_id')
            )
        );

        return $this->response->json(['uuid' => $uuid]);
    }
}
