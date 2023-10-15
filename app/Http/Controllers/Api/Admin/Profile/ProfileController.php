<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Profile;

use App\Data\Profile\ChangePasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\ChangePasswordRequest;
use App\Http\Requests\Admin\Profile\ProfileUpdateRequest;
use App\Models\Auth\AppAuth;
use App\Models\Auth\AuthModel;
use App\Services\Api\Contracts\ProfileService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Project\Domains\Admin\Profile\Application\Queries\GetProfile\Query;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class ProfileController extends Controller
{
    private readonly ?AuthModel $authModel;

    public function __construct(
        private readonly ResponseFactory $response,
        private readonly ProfileService $service,
        private readonly QueryBusInterface $queryBus,
        private readonly CommandBusInterface $commandBus,
    ) {
        $this->authModel = AppAuth::model();
    }

    public function show(): JsonResponse
    {
        $result = $this->queryBus->ask(
            new Query()
        );

        return $this->response->json($result);
    }

    public function update(ProfileUpdateRequest $request): Response
    {
        $this->commandBus->dispatch(
            new \Project\Domains\Admin\Profile\Application\Commands\Update\Command(
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
                $request->get('current_password'),
                $request->get('password')
            )
        );

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
