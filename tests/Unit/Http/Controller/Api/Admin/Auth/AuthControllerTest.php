<?php

namespace Tests\Unit\Http\Controller\Api\Admin\Auth;

use App\Models\Admin;
use App\Models\Device;
use App\Models\Enums\AppGuardType;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tymon\JWTAuth\Claims\Custom;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Payload;
use Tymon\JWTAuth\Token;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * @dataProvider credentialsProvider
     */
    public function test_register(array $credentials): void
    {
        $credentials = $credentials + [
            'password_confirmation' => '12345Secret_',
        ];

        $this->postJson(route('admin.auth.register'), $credentials)->assertStatus(Response::HTTP_ACCEPTED);

        $this->assertDatabaseHas('admins', [
            'first_name' => null,
            'last_name' => null,
            'email' => $credentials['email'],
        ]);
    }

    /**
     * @dataProvider credentialsProvider
     */
    public function test_login(array $credentials): void
    {
        $credentials['role_id'] = Role::query()->first()->value('id');

        $deviceId = 'test-device-id';
        $admin = Admin::factory()->create($credentials);

        $response = $this->postJson(route('admin.auth.login'), $credentials, ['x-device-id' => $deviceId])->assertOk();
        $this->assertAuthenticated(AppGuardType::ADMIN->value);
        $this->assertAuthenticatedAs($admin, AppGuardType::ADMIN->value);

        $response->assertJsonStructure([
            'access_token',
            'refresh_token',
            'token_type',
            'expires_in',
            'auth_data',
        ]);

        $responseAccessToken = $response->json('access_token');
        $tokenObj = new Token($responseAccessToken);

        /** @var Payload $decodedJWTTokenPayload */
        $decodedJWTTokenPayload = JWTAuth::decode($tokenObj);

        // Test Role and Permissions
        $this->assertTrue($decodedJWTTokenPayload->getClaims()->has('role'));
        /** @var Custom $JWTClaimCustom */
        $JWTRoleClaimCustom = $decodedJWTTokenPayload->getClaims()->keyBy('role')->first();
        $JWTRoleClaimCustomArr = $JWTRoleClaimCustom->getValue();

        $this->assertSame($JWTRoleClaimCustomArr['value'], 'admin');
        $this->assertArrayHasKey('permissions', $JWTRoleClaimCustomArr);
        $this->assertTrue(count($JWTRoleClaimCustomArr['permissions']) > 0);

        // Test Device
        $this->assertDatabaseHas(Device::class, [
            'device_able_id' => $admin->id,
            'device_able_type' => $admin->getMorphClass(),
            'refresh_token' => $response->json('refresh_token'),
            'device_id' => $deviceId,
            'device_name' => '',
            'user_agent' => '',
            'os' => '',
            'os_version' => '',
            'app_version' => '',
            'ip_address' => '',
            'location' => '',
            'expired_at' => now()->addDays(30),
        ]);
    }

    /**
     * @depends test_login
     */
    public function test_refresh_token(): void
    {
        $credentials['role_id'] = Role::query()->first()->value('id');
        $deviceId = 'test-device-id';

        $admin = Admin::factory()->create($credentials);
        $device = $admin->addDevice($deviceId);

        $data = [
            'refresh_token' => $device->refresh_token,
        ];

        $response = $this->postJson(route('admin.auth.refresh-token'), $data, ['x-device-id' => $deviceId]);
        $response->assertStatus(Response::HTTP_ACCEPTED);

        $response->assertJsonStructure([
            'access_token',
            'refresh_token',
            'token_type',
            'expires_in',
            'auth_data',
        ]);

        $responseAccessToken = $response->json('access_token');
        $tokenObj = new Token($responseAccessToken);

        /** @var Payload $decodedJWTTokenPayload */
        $decodedJWTTokenPayload = JWTAuth::decode($tokenObj);

        // Test Role and Permissions
        $this->assertTrue($decodedJWTTokenPayload->getClaims()->has('role'));
        /** @var Custom $JWTClaimCustom */
        $JWTRoleClaimCustom = $decodedJWTTokenPayload->getClaims()->keyBy('role')->first();
        $JWTRoleClaimCustomArr = $JWTRoleClaimCustom->getValue();

        $this->assertSame($JWTRoleClaimCustomArr['value'], 'admin');
        $this->assertArrayHasKey('permissions', $JWTRoleClaimCustomArr);
        $this->assertTrue(count($JWTRoleClaimCustomArr['permissions']) > 0);

        // Test Device
        $this->assertDatabaseHas(Device::class, [
            'device_able_id' => $admin->id,
            'device_able_type' => $admin->getMorphClass(),
            'refresh_token' => $response->json('refresh_token'),
            'device_id' => $deviceId,
            'device_name' => '',
            'user_agent' => '',
            'os' => '',
            'os_version' => '',
            'app_version' => '',
            'ip_address' => '',
            'location' => '',
            'expired_at' => now()->addDays(30),
        ]);
    }

    /**
     * @dataProvider credentialsProvider
     */
    public function test_logout(array $credentials): void
    {
        $credentials['role_id'] = Role::query()->first()->value('id');
        $deviceId = 'test-device-id';

        $admin = Admin::factory()->create($credentials);

        $token = JWTAuth::fromUser($admin);

        $response = $this->postJson(route('admin.auth.logout').'?'.http_build_query(compact('token')), [], ['x-device-id' => $deviceId])->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertGuest(AppGuardType::ADMIN->value);
    }

    public function credentialsProvider(): array
    {
        return
        [
            [
                [
                    'email' => 'adminTest@gmail.com',
                    'password' => '12345Secret_',
                    'role_id' => 1,
                ],
            ],
        ];
    }
}
