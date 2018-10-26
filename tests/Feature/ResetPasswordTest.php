<?php

namespace Jijoel\AuthApi\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Password;


class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    const PATH = '/api/password/reset';

    /** @test */
    public function it_returns_an_error_if_data_not_sent()
    {
        $this->postJson(self::PATH, [])
            ->assertStatus(422)
            ->assertJsonStructure(['errors' => ['token','email','password']]);
    }

    /**
     * @test
     * @dataProvider getInvalidData
     */
    public function it_returns_an_error_if_recieving_invalid_data($err, $data)
    {
        $this->postJson(self::PATH, $data)
            ->assertStatus(422)
            ->assertJsonStructure(['errors' => [$err]]);
    }

    public function getInvalidData()
    {
        return array(
            ['email', $this->data(['email'=>null])],
            ['password', $this->data(['password'=>null])],
            ['token', $this->data(['token'=>null])],
            ['email', $this->data(['email'=>'x@y'])],
            ['password', $this->data(['password_confirmation'=>null])],
            ['password', $this->data(['password_confirmation'=>'x'])],
            ['email', $this->data()],  // missing user
        );
    }

    private function data($attrs = [])
    {
        return array_merge([
            'email'=>'foo@bar.com',
            'password'=>'secret',
            'password_confirmation'=>'secret',
            'token'=>'x',
        ], $attrs);
    }

    /** @test */
    public function it_returns_error_if_user_not_found()
    {
        $this->postJson(self::PATH, $this->data(['email'=>'foo@bar.com']))
            ->assertStatus(422)
            ->assertJsonStructure(['errors' => ['email']]);
    }

    /** @test */
    public function it_resets_user_password()
    {
        Password::shouldReceive('broker->reset')
            ->once()->andReturn('passwords.reset');

        $this->postJson(self::PATH, $this->data())
            ->assertStatus(200);
    }

}
