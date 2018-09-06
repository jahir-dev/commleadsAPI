<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\models\Buyer::class, function (Faker $faker) {
    return [
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'isActive' => $faker->boolean,
        'isPremium' => $faker->boolean,
        'isExpired' => $faker->boolean(),
        'registrationDate' => $faker->dateTime(),
        'lastLoginDate' => $faker->dateTime,
        'numberOfLogs' => $faker->numberBetween(),
        'country_id' => $faker->numberBetween(1,243),
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});
