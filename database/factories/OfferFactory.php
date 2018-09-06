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

$factory->define(App\models\Offer::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'content' => $faker->realText(),
        'createDate' => $faker->dateTime,
        'publishDate' => $faker->dateTime,
        'expireDate' => $faker->dateTime,
        'buyer_id' => $faker->numberBetween(1,50),
        'category_id' => $faker->numberBetween(1,768),
    ];
});
