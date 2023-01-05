<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\Api\Admin\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $service,
    ) {
        parent::middleware('guest');
    }

    public function login(Request $request): JsonResponse
    {
        $result = $this->service->login($request->all());

        return response()->json($result);
    }
}
