<?php

namespace Jijoel\AuthApi\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Password;


class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    const PATH = '/api/password/email';

    /** @test */
    public function it_returns_error_if_data_not_sent()
    {
        $this->postJson(self::PATH, [])
            ->assertStatus(422)
            ->assertJsonStructure(['errors' => ['email']]);
    }

    /** @test */
    public function it_returns_error_if_user_not_found()
    {
        $this->postJson(self::PATH, ['email'=>'foo@bar.com'])
            ->assertStatus(422)
            ->assertJsonStructure(['errors' => ['email']]);
    }

    /** @test */
    public function it_sends_an_email_with_password_link()
    {
        Password::shouldReceive('broker->sendResetLink')
            ->once()->andReturn('passwords.sent');

        $this->postJson(self::PATH, ['email'=>'foo@bar.com'])
            ->assertStatus(200);
    }
}
