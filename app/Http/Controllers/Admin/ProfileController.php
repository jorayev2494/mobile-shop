<?php

namespace App\Http\Controllers\Admin;

use App\Data\Models\AdminData;
use App\Data\Profile\ChangePasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\ChangePasswordRequest;
use App\Http\Requests\Admin\Profile\ProfileUpdateRequest;
use App\Models\Auth\AppAuth;
use App\Models\Auth\AuthModel;
use App\Services\Api\Contracts\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    private readonly ?AuthModel $authModel;

    public function __construct(
        private readonly ProfileService $service,
    ) {
        $this->authModel = AppAuth::model();
    }

    public function show(): JsonResponse
    {
        return response()->json(
            $this->service->show($this->authModel)
        );
    }

    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        $data = AdminData::makeFromFormRequest($request);

        return response()->json(
            $this->service->update($this->authModel, $data)
        );
    }

    public function changePassword(ChangePasswordRequest $request): Response
    {
        $data = ChangePasswordData::makeFromFormRequest($request);
        $this->service->changePassword($this->authModel, $data);

        return response()->noContent(Response::HTTP_ACCEPTED);
    }
}
