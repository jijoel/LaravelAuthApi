Laravel Auth Api
=====================

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Use an api to authenticate users.


## Installation

Via Composer

``` bash
$ composer require jijoel/laravel-auth-api
```

This package works in conjunction with a front-end component pack, based on [Vuetify](https://vuetify.com). To install the front-end components:

``` bash
$ yarn add vuetify-api-auth
```

To scaffold the authentication controllers:

``` bash
$ php artisan make:api-auth
```

To scaffold front-end components:

``` bash
$ php artisan make:api-js
```

## Configuration

To automatically generate routes, include this in `routes/api.php`:

``` php
AuthApi::routes();
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

Specify a list of user-selectable language translations for your site by creating a list of locales in `config/app.php`:

``` php
'locale' => 'en',

'locales' => ['en','es'],   // English and Spanish
```

## Usage

`php artisan make:api-auth`
: Generate authentication controllers

`php artisan make:api-js`
: Generate front-end javascript files based on vuetify.js


## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please [email](mailto://jijoel@yahoo.com) instead of using the issue tracker.

## Credits

- [Author][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/jijoel/laravel-auth-api.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/jijoel/laravel-auth-api.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jijoel/laravel-auth-api/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/jijoel/laravel-auth-api
[link-downloads]: https://packagist.org/packages/jijoel/laravel-auth-api
[link-travis]: https://travis-ci.org/jijoel/laravel-auth-api
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/jijoel
[link-contributors]: contributors.md
