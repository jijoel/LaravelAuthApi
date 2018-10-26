<?php

namespace Jijoel\AuthApi\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Laravel\Passport\PersonalAccessTokenFactory;
use Mockery;

class LoginTest extends TestCase
{
    use CreatesUsers, RefreshDatabase;

    const PATH = '/api/login';

    /** @test */
    public function it_returns_error_if_data_not_sent()
    {
        $this->postJson(self::PATH, [])
            ->assertStatus(422)
            ->assertJsonStructure(['errors' => ['email','password']]);
    }

    /** @test */
    public function it_allows_login_from_known_user()
    {
        $user = $this->createUser();

        $passport = Mockery::mock(PersonalAccessTokenFactory::class)
            ->shouldReceive('make')->once()
            ->andReturn((object)['accessToken'=>'xxx'])
            ->getMock();

        $this->app->instance(PersonalAccessTokenFactory::class, $passport);

        $this->postJson(self::PATH, $this->userAttrs())
            ->assertStatus(200)
            ->assertJsonStructure(['token','token_type']);
    }

    /** @test */
    public function it_rejects_an_incorrect_password()
    {
        $user = $this->createUser();

        $this->postJson(self::PATH, $this->userAttrs(['password'=>'x']))
            ->assertStatus(422)
            ->assertJsonStructure(['errors' => ['email']]);
    }

    /** @test */
    public function it_asks_for_social_login_if_no_password_is_set()
    {
        $user = $this->createUser(['password'=>null]);

        $this->postJson(self::PATH, $this->userAttrs())
            ->assertStatus(422)
            ->assertJsonStructure(['errors' => ['email']])
            ->assertSee('social media');
    }
}
