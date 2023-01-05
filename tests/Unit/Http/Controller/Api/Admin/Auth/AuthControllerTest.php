<?php

namespace Tests\Unit\Http\Controller\Api\Admin\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        //
    }

    public function test_login(): void
    {
        $data = [
            'email' => 'admin@gmail.com',
            'password' => '12345Secret!',
        ];

        $response = $this->postJson(route('admin.auth.login'), $data)->assertOk();
        $response->assertJsonFragment([
            ...$data,
        ]);
    }
}
