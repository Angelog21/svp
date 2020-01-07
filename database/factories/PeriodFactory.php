<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Period;
use Faker\Generator as Faker;
use App\User;
use App\Person;

$factory->define(Period::class, function (Faker $faker) {
    return [
        'user_id'=>User::all()->random()->id,
        'period'=> $faker->randomElement(['2010-2011','2011-2012','2012-2013','2013-2014','2014-2015','2015-2016','2016-2017']),
        'expiration_date'=>Person::all()->random()->date_admission,
        'available_days'=>30
    ];
});
