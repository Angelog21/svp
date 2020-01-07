<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Area;
use Faker\Generator as Faker;
use App\Direction;

$factory->define(Area::class, function (Faker $faker) {
    return [
        'direction_id'=> Direction::all()->random()->id,
        'name'=> $faker->sentence
    ];
});
