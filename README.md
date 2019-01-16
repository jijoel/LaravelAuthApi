Laravel Auth Api
=====================

Backend for an api to authenticate users, including both local and social authentication.

It uses [Laravel Passport][passport] for API authentication and tokens, and [Laravel Socialite][socialite] for social authentication. These packages are automatically included.

In the future, this package will work in conjunction with a front-end component pack.


## Installation

Via Composer

``` bash
$ composer require jijoel/laravel-auth-api
```

## Configuration

To scaffold the authentication controllers:

``` bash
$ php artisan make:api-auth
```

To automatically generate routes, include this in `routes/api.php`:

``` php
ApiAuth::routes();
ApiAuth::socialRoutes();      // oauth routes

ApiAuth::routes(['social']);  // include oauth routes
```

Add a relationship to linked social accounts to your user model:

``` php
public function linkedSocialAccounts()
{
    return $this->hasMany('Jijoel\AuthApi\LinkedSocialAccount');
}
```

## Usage

The `ApiAuth::routes()` method, above, will create these endpoints:

Methods  | Route                       | Route Name
---------|-----------------------------|----------------
POST     | api/login                   | login
POST     | api/logout                  | logout
GET|HEAD | api/oauth/{driver}          | oauth.redirect
GET|HEAD | api/oauth/{driver}/callback | oauth.callback
POST     | api/password/email          | password.email
POST     | api/password/reset          | password.reset
POST     | api/register                | register

It also sets up an @config blade compiler directive, so you can load application-specific configuration into your javascript. By default, it will include this configuration:

    'appName' => config('app.name'),
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales'),




## Change log

Please see the [changelog](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please [email](mailto://jijoel@yahoo.com) instead of using the issue tracker.

## Credits

- [Author][link-author]
- [All Contributors][link-contributors]

https://medium.com/@hivokas/api-authentication-via-social-networks-for-your-laravel-application-d81cfc185e60

## License

license. Please see the [license file](license.md) for more information.

[link-author]: https://github.com/jijoel
[link-contributors]: contributors.md
[passport]: https://laravel.com/docs/passport
[socialite]: https://laravel.com/docs/socialite
