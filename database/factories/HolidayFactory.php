<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Holiday;
use Faker\Generator as Faker;
use App\User;
use App\Period;

$factory->define(Holiday::class, function (Faker $faker) {
    return [
        'applicant_id'=>User::all()->random()->id,
        'supervisor_id'=>User::all()->random()->id,
        'approver_id'=>User::all()->random()->id,
        'office_id'=>2,
        'request_days'=>30,
        'enjoyed_days'=>30,
        'leftover_days'=>0,
        'start_date'=> $faker->date($format='Y-m-d', $max='now'),
        'end_date'=> $faker->date($format='Y-m-d', $min='now'),
        'refund_date'=> $faker->date($format='Y-m-d', $min='now'),
        'observation'=>"hola",
        'state'=> Holiday::COMPLETO
    ];
});
