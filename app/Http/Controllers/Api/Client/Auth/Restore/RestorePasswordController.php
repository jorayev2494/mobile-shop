<?php

namespace App\Http\Controllers\Api\Client\Auth\Restore;

use App\Data\Auth\RestorePasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\Restore\RestorePasswordLinkRequest;
use App\Http\Requests\Client\Auth\Restore\RestorePasswordRequest;
use App\Models\Enums\AppGuardType;
use App\Services\Api\Auth\RestorePasswordService;
use Illuminate\Http\Response;

class RestorePasswordController extends Controller
{
    public function __construct(
        private readonly RestorePasswordService $service,
    ) {
    }

    public function link(RestorePasswordLinkRequest $request): Response
    {
        $this->service->link($request->get('email'), AppGuardType::CLIENT);

        return response()->noContent(Response::HTTP_ACCEPTED);
    }

    public function restore(RestorePasswordRequest $request): Response
    {
        $data = RestorePasswordData::makeFromFormRequest($request);
        $this->service->restore($data, AppGuardType::CLIENT);

        return response()->noContent(Response::HTTP_ACCEPTED);
    }
}
