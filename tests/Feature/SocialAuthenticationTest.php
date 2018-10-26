<?php

namespace Jijoel\AuthApi\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Laravel\Passport\PersonalAccessTokenFactory;
use Laravel\Socialite\Facades\Socialite;
use Mockery;

class SocialAuthenticationTest extends TestCase
{
    use CreatesUsers, RefreshDatabase;

    const PATH = '/api/oauth/provider';

    /** @test */
    public function it_returns_a_path_to_oauth_provider_page()
    {
        $path = 'http://foo.com';
        Socialite::shouldReceive('driver->stateless->redirect->getTargetUrl')
            ->once()->andReturn($path);

        $this->getJson(self::PATH)
            ->assertStatus(200)
            ->assertJson(['url'=>$path]);
    }

    /** @test */
    public function it_returns_a_token_for_new_user()
    {
        $this->withoutExceptionHandling();
        $passport = $this->setupMockPassport();
        $socialUser = $this->setupSocialUser();

        $this->getJson(self::PATH.'/callback')
            ->assertStatus(200)
            ->assertJsonStructure(['token','token_type']);
    }

    private function setupSocialUser()
    {
        $user = Mockery::mock('Laravel\Socialite\Two\User')
            ->shouldReceive('getId')->andReturn(1)
            ->shouldReceive('getEmail')->andReturn('foo@bar.com')
            ->shouldReceive('getName')->andReturn('Foo')
            ->getMock();

        Socialite::shouldReceive('driver->stateless->user')
            ->once()->andReturn($user);

        return $user;
    }

    private function setupMockPassport()
    {
        $passport = Mockery::mock(PersonalAccessTokenFactory::class)
            ->shouldReceive('make')->once()
            ->andReturn((object)['accessToken'=>'xxx'])
            ->getMock();

        $this->app->instance(PersonalAccessTokenFactory::class, $passport);

        return $passport;
    }
}
