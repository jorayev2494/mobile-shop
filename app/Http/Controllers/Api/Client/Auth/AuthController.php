<?php

namespace App\Http\Controllers\Api\Client\Auth;

use App\Data\Auth\AuthCredentialsData;
use App\Data\Auth\RefreshTokenData;
use App\Data\Auth\RegisterData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\LoginRequest;
use App\Http\Requests\Client\Auth\LogoutRequest;
use App\Http\Requests\Client\Auth\RefreshTokenRequest;
use App\Http\Requests\Client\Auth\RegisterRequest;
use App\Models\Auth\AppAuth;
use App\Models\Enums\AppGuardType;
use App\Services\Api\Contracts\AuthService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly AuthService $service,
    ) {
        // parent::middleware('guest')->except('logout');
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $registerData = RegisterData::makeFromFormRequest($request);
        $registeredModel = $this->service->register($registerData, AppGuardType::CLIENT);

        return $this->response->json(['uuid' => $registeredModel->uuid], Response::HTTP_ACCEPTED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = AuthCredentialsData::makeFromFormRequest($request);
        $result = $this->service->login($data, AppGuardType::CLIENT);

        return $this->response->json($result);
    }

    public function refreshToken(RefreshTokenRequest $request): JsonResponse
    {
        $data = RefreshTokenData::makeFromFormRequest($request);
        $result = $this->service->refreshToken($data, AppGuardType::CLIENT);

        return $this->response->json($result, Response::HTTP_ACCEPTED);
    }

    public function logout(LogoutRequest $request): Response
    {
        $this->service->logout(AppAuth::model(), $request->headers->get('x-device-id'), AppGuardType::CLIENT);

        return $this->response->noContent();
    }
}
