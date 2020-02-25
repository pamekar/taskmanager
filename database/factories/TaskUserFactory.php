<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TaskUser;
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

$factory->define(TaskUser::class, function (Faker $faker, $args) {
    return [
        'task_id'=>$args['task_id'],
        'user_id'=>$args['user_id'],
        'status'=> $faker->randomElement(['pending','active','completed'])
    ];
});
