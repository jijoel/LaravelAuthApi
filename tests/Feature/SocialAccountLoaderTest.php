<?php

namespace Jijoel\AuthApi\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Jijoel\AuthApi\Tests\Models\User;
use Jijoel\AuthApi\LinkedSocialAccount;
use Laravel\Socialite\Two\User as ProviderUser;
use Mockery;

use Jijoel\AuthApi\SocialAccountLoader;


class SocialAccountLoaderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_find_an_existing_provider_record()
    {
        $model = factory(LinkedSocialAccount::class)->create();
        $providerUser = Mockery::mock(ProviderUser::class)
            ->shouldReceive('getId')->andReturn($model->provider_id)
            ->getMock();

        $test = new SocialAccountLoader;

        $result = $test->findOrCreate($providerUser, 'github');

        $this->assertInstanceOf(User::class, $result);
    }

    /** @test */
    public function it_can_add_provider_to_existing_user()
    {
        $user = factory(User::class)->create();
        $providerUser = Mockery::mock(ProviderUser::class)
            ->shouldReceive('getId')->andReturn('id_x')
            ->shouldReceive('getEmail')->andReturn($user->email)
            ->getMock();

        $test = new SocialAccountLoader;

        $this->assertEquals(0, $user->linkedSocialAccounts()->count());
        $result = $test->findOrCreate($providerUser, 'github');
        $this->assertEquals(1, $user->linkedSocialAccounts()->count());
    }

    /** @test */
    public function it_creates_a_user_if_none_exists()
    {
        $providerUser = Mockery::mock(ProviderUser::class)
            ->shouldReceive('getId')->andReturn('id-x')
            ->shouldReceive('getName')->andReturn('Foo')
            ->shouldReceive('getEmail')->andReturn('foo@bar.com')
            ->getMock();

        $test = new SocialAccountLoader;

        $this->assertCount(0, User::all());
        $result = $test->findOrCreate($providerUser, 'github');

        $this->assertCount(1, User::all());
        $this->assertEquals(1, $result->linkedSocialAccounts()->count());
        $this->assertInstanceOf(User::class, $result);
    }

    /** @test */
    public function it_can_have_multiple_users_with_no_email()
    {
        $users = [ ['id' => 'id-x', 'name' => 'Foo'],
                   ['id' => 'id-y', 'name' => 'Second'] ];

        $providers = [];

        foreach ($users as $user) {
            $providers[] = Mockery::mock(ProviderUser::class)
                ->shouldReceive('getId')->andReturn($user['id'])
                ->shouldReceive('getName')->andReturn($user['name'])
                ->shouldReceive('getEmail')->andReturn(null)
                ->getMock();
        }

        $test = new SocialAccountLoader;

        $this->assertCount(0, User::all());
        $test->findOrCreate($providers[0], 'github');
        $test->findOrCreate($providers[1], 'github');
        $this->assertCount(2, User::all());
    }
}
