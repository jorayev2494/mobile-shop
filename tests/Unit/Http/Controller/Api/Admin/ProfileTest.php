<?php

namespace Tests\Unit\Http\Controller\Api\Admin;

use App\Models\Admin;
use App\Models\Enums\AppGuardType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // $this->seed();
    }

    public function test_change_password(): void
    {
        $admin = Admin::factory()->withRole()->create();

        $token = JWTAuth::fromUser($admin);

        $newPassword = '12345Changed_';

        $data = [
            'current_password' => '12345Secret_',
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ];

        $response = $this->putJson(route('admin.profile.change_password').'?'.http_build_query(compact('token')), $data, ['x-device-id' => 'test-device']);
        $response->assertStatus(Response::HTTP_ACCEPTED);

        $loginData = [
            'email' => $admin->email,
            'password' => $newPassword,
        ];

        $this->postJson(route('admin.auth.logout').'?'.http_build_query(compact('token')), [], ['x-device-id' => 'test-device'])->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertCredentials($loginData, AppGuardType::ADMIN->value);

        $responseLogin = $this->postJson(route('admin.auth.login'), $loginData, ['x-device-id' => 'test-device']);
        $responseLogin->assertOk();
    }
}
