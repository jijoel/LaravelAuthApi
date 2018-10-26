<?php

namespace Jijoel\AuthApi\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', 'Jijoel\AuthApi\Tests\Models\User');
        $app['config']->set('app.key', 'base64:SKXWpLQ+uNyC6aJ4ZaBpB9QjNNx6DUZc6xxqibmhF5k=');
        $app['config']->set('app.cipher', 'AES-256-CBC');
    }

    protected function getPackageProviders($app)
    {
        return [
            'Laravel\Passport\PassportServiceProvider',
            'Jijoel\AuthApi\Tests\TestServiceProvider',
        ];
    }
}
