<?php

namespace Jijoel\AuthApi\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Jijoel\AuthApi\Tests\Models\User;
use Hash;


class RegistrationTest extends TestCase
{
    use CreatesUsers, RefreshDatabase;

    const PATH = '/api/register';

    /** @test */
    public function it_returns_error_if_missing_required_data()
    {
        $this->postJson(self::PATH, [])
            ->assertStatus(422)
            ->assertJsonStructure(['errors' => ['name','email','password']]);
    }

    /** @test */
    public function it_returns_error_if_duplicate_email()
    {
        $this->createUser();

        $this->postJson(self::PATH, $this->userAttrs([
            'name' => 'Foo',
            'password_confirmation' => 'secret'
        ]))->assertStatus(422)
            ->assertJsonStructure(['errors' => ['email']])
            ->assertSee('taken');
    }

    /** @test */
    public function it_registers_a_user()
    {
        $this->postJson(self::PATH, $this->userAttrs([
            'name' => 'Foo',
            'password_confirmation' => 'secret'
        ]))->assertStatus(201)
            ->assertJsonStructure(['status','user']);
    }

}
