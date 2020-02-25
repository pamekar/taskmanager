<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Task::class, function (Faker $faker, $args) {
    return [
        'title' => $faker->realText(40),
        'description' => $faker->realText(400),
        'is_compulsory' => false,
        'start_at' => null,
        'end_at' => null,
        'user_id' => $args['user_id']
    ];
});
