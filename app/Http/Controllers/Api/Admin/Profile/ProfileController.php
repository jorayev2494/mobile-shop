<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Profile;

use App\Data\Profile\ChangePasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\ChangePasswordRequest;
use App\Http\Requests\Admin\Profile\ProfileUpdateRequest;
use App\Models\Auth\AppAuth;
use App\Models\Auth\AuthModel;
use App\Models\Enums\AppGuardType;
use App\Services\Api\Contracts\ProfileService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Project\Domains\Admin\Profile\Application\Queries\GetProfile\Query;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

class ProfileController extends Controller
{

    public function __construct(
        private readonly ResponseFactory $response,
        private readonly ProfileService $service,
        private readonly QueryBusInterface $queryBus,
        private readonly AuthManagerInterface $authManager,
        private readonly CommandBusInterface $commandBus,
    ) {
        
    }

    public function show(): JsonResponse
    {
        $result = $this->queryBus->ask(
            new Query($this->authManager->uuid(AppGuardType::ADMIN))
        );

        return $this->response->json($result);
    }

    public function update(ProfileUpdateRequest $request): Response
    {
        $this->commandBus->dispatch(
            new \Project\Domains\Admin\Profile\Application\Commands\Update\Command(
                $this->authManager->uuid(AppGuardType::ADMIN),
                $request->get('first_name'),
                $request->get('last_name'),
                $request->get('email'),
                $request->file('avatar'),
                $request->get('phone'),
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }

    public function changePassword(ChangePasswordRequest $request): Response
    {
        $this->commandBus->dispatch(
            new \Project\Domains\Admin\Profile\Application\Commands\ChangePassword\Command(
                $this->authManager->uuid(AppGuardType::ADMIN),
                $request->get('current_password'),
                $request->get('password')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
