<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models;
use Faker\Generator as Faker;

$factory->define(Models\Status::class, function (Faker $faker) {
    $data_time = $faker->date . ' ' . $faker->time;
    return [
        'content' => $faker->text(),
        'created_at' => $data_time,
        'updated_at' => $data_time,
    ];
});
