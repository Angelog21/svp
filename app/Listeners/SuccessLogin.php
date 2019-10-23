<?php

namespace App\Listeners;

use DateTime;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Period;
use App\Person;
use App\Http\Controllers\Period\PeriodController;

class SuccessLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $event->user->last_login = new DateTime();
        $event->user->save();
        //añadir periodo si ya se cumple la fecha
        $vp = Period::validatePeriod();
        if($vp === true){
            $date_admission = Person::getDateAdmission();
            $date1 = date('Y').'-'.substr($date_admission,5);
            if($date1 <= date('Y-m-d')){
                PeriodController::newPeriod();
                alert()->success("Usted tiene un período vencido")->persistent();
            }

        }
    }
}
