<?php

namespace Tests\Unit\Http\Controller\Api\Admin\Auth;

use App\Mail\Admin\Auth\SendRestoreLinkEmail;
use App\Mail\Auth\SendRestoreLinkEmail as UserSendRestoreLinkEmail;
use App\Models\Admin;
use App\Models\Code;
use App\Models\Enums\AppGuardType;
use App\Models\Enums\CodeType;
use App\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RestorePasswordTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_request_password_restore_link(): Code
    {
        $this->seed();

        $admin = Admin::factory()->create([
            'role_id' => Role::query()->first()->value('id'),
        ]);

        $mailFake = Mail::fake();

        $response = $this->postJson(route('admin.auth.restore_password.link'), ['email' => $admin->email]);
        $response->assertStatus(Response::HTTP_ACCEPTED);

        $mailFake->assertNotSent(SendRestoreLinkEmail::class);
        $mailFake->assertQueued(SendRestoreLinkEmail::class);

        $mailFake->assertNotSent(UserSendRestoreLinkEmail::class);
        $mailFake->assertNotQueued(UserSendRestoreLinkEmail::class);

        /** @var Code $sentCode */
        $sentCode = $admin->codes()->latest()->first();

        $this->assertDatabaseHas('codes', [
            'code_able_id' => $admin->id,
            'code_able_type' => $admin->getMorphClass(),
            'type' => CodeType::RESTORE_PASSWORD_LINK,
            'value' => null,
            'token' => $sentCode->token,
            'guard' => AppGuardType::ADMIN,
        ]);

        return $sentCode;
    }

    /**
     * @depends test_request_password_restore_link
     */
    public function test_restore_password(Code $code): void
    {
        $data = [
            'token' => $code->token,
            'password' => '12345USecret_',
            'password_confirmation' => '12345USecret_',
        ];

        $response = $this->putJson(route('admin.auth.restore_password.restore'), $data);
        $response->assertStatus(Response::HTTP_ACCEPTED);

        $this->assertDatabaseMissing('codes', [
            'code_able_id' => $code->code_able_id,
            'code_able_type' => $code->code_able_type,
            'type' => CodeType::RESTORE_PASSWORD_LINK,
            'value' => null,
            'token' => $code->token,
            'guard' => AppGuardType::ADMIN,
        ]);
    }
}
