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

    public function test_get_profile(): void
    {
        $admin = Admin::factory()->withRole()->create();
        $this->actingAs($admin, AppGuardType::ADMIN->value);

        $response = $this->getJson(route('admin.profile.show'))->assertOk();

        $response->assertJsonFragment([
            'id' => $admin->id,
            'first_name' => $admin->first_name,
            'last_name' => $admin->last_name,
            'email' => $admin->email,
            'role_id' => $admin->role_id,
        ]);
    }

    public function test_update_profile(): void
    {
        $admin = Admin::factory()->withRole()->create();
        
        $data = [
            'first_name' => 'AlexU',
            'last_name' => 'PetrovU',
            'email' => 'alexU12345@gmail.com',
            // 'role_id' => $admin->role_id,
        ];

        $this->assertDatabaseHas(Admin::class, $admin->toArray());
        
        $this->actingAs($admin, AppGuardType::ADMIN->value);
        $response = $this->postJson(route('admin.profile.update'), $data)->assertStatus(Response::HTTP_ACCEPTED);

        $response->assertJsonFragment([
            'id' => $admin->id,
            'first_name' => $admin->first_name,
            'last_name' => $admin->last_name,
            'email' => $admin->email,
            'role_id' => $admin->role_id,
        ]);

        $this->assertDatabaseHas(Admin::class, $response->json());
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

        $response = $this->putJson(route('admin.profile.change_password') . '?' . http_build_query(compact('token')), $data, ['x-device-id' => 'test-device']);
        $response->assertStatus(Response::HTTP_ACCEPTED);

        $loginData = [
            'email' => $admin->email,
            'password' => $newPassword,
        ];

        $this->postJson(route('admin.auth.logout') . '?' . http_build_query(compact('token')), [], ['x-device-id' => 'test-device'])->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertCredentials($loginData, AppGuardType::ADMIN->value);

        $responseLogin = $this->postJson(route('admin.auth.login'), $loginData, ['x-device-id' => 'test-device']);
        $responseLogin->assertOk();
    }

    public function test_incomplete(): void
    {
        $this->markTestIncomplete('Incomplete message');
    }

    public function test_skipped(): void
    {
        $this->markTestSkipped('Skipped message');
    }
}
