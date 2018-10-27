<?php

use App\User;

use Faker\Generator as Faker;
use Jijoel\AuthApi\LinkedSocialAccount;

$factory->define(
    LinkedSocialAccount::class,
    function (Faker $faker)
{
    return [
        'provider_id' => $faker->sha1,
        'provider_name' => 'github',
        'user_id' => factory(LinkedSocialAccount::userClass())->create()->id,
    ];
});
