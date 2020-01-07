<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Permit;
use Faker\Generator as Faker;
use App\Reason;

$factory->define(Permit::class, function (Faker $faker) {
    return [
        'employee_id'=>Employee::all()->random()->id,
        'supervisor_id'=>Supervisor::all()->random()->id,
        'office_id'=>2,
        'start_date'=> $faker->date($format='d-m-Y', $min='now'),
        'end_date'=> $faker->date($format='d-m-Y', $min='now'),
        'refund_date'=> $faker->date($format='d-m-Y', $min='now'),
        'reason_id'=> Reason::all()->random()->id,
        'days'=> rand(1,30),
        'turn'=>$faker->randomElement(['c','m','t']),
        'remunerate'=>1,
        'substitute_require'=> rand(0,1),
        'description'=> $faker->sentence(),
        'observation'=>"hola",
        'state'=> $faker->randomElement([Permit::PROCESO, Permit::RECHAZADO,Permit::APROBADO,Permit::COMPLETO])
    ];
});
