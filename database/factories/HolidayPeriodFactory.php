<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\HolidayPeriod;
use Faker\Generator as Faker;
use App\Holiday;
use App\Period;

$factory->define(HolidayPeriod::class, function (Faker $faker) {
    return [
        'holiday_id'=>Holiday::all()->random()->id,
        'period_id'=>Period::all()->random()->id
    ];
});
