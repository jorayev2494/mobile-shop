<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Auth\Restore;

use App\Data\Auth\RestorePasswordData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\Restore\RestorePasswordLinkRequest;
use App\Http\Requests\Admin\Auth\Restore\RestorePasswordRequest;
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
        $this->service->link($request->get('email'), AppGuardType::ADMIN);

        return response()->noContent(Response::HTTP_ACCEPTED);
    }

    public function restore(RestorePasswordRequest $request): Response
    {
        $data = RestorePasswordData::makeFromFormRequest($request);
        $this->service->restore($data, AppGuardType::ADMIN);

        return response()->noContent(Response::HTTP_ACCEPTED);
    }
}
