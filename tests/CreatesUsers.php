<?php

namespace Jijoel\AuthApi\Tests;

use Jijoel\AuthApi\Tests\Models\User;
use Hash;

trait CreatesUsers
{
    protected function userAttrs($attrs = [])
    {
        return array_merge([
            'email' => 'foo@bar.com',
            'password' => 'secret',
        ], $attrs);
    }

    protected function createUser($attrs = [])
    {
        $user = $this->userAttrs($attrs);
        if ($user['password'])
            $user['password'] = Hash::make($user['password']);

        return factory(User::class)->create($user);
    }
}
