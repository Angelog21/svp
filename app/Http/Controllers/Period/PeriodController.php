<?php

namespace App\Http\Controllers\Period;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Period;
use Carbon\Carbon;

class PeriodController extends Controller
{
    public static function newPeriod(){
        $p = Period::validatePeriod();
        $yearact = date('Y');
        $year2 = Carbon::now()->addYear()->format('Y');
        $newPeriod = $yearact . '-' . $year2;
        if($p === true){
            $newp = new Period;
            $newp->user_id = auth()->user()->id;
            $newp->period = $newPeriod;
            $newp->expiration_date = $yearact.'-'.substr(auth()->user()->person->date_admission,5);
            $newp->available_days = 30;
            $newp->save();
            return $newp->id;
        }else{
            return null;
        }
    }

    public function store(Request $request){
        $p = $request['periods'];
        $a = 0;
        $periods = Period::where('user_id',$request['user_id'])->get('period')->toArray();
        for($i = 0; $i < $p; $i++){
            $period = $request['period'.($i+1)];
            $expdate = $request['expiration_date'.($i+1)];
            $days = $request['available_days'.($i+1)];
            try{
                if($request[$period] == "on"){
                    if(array_search($period,array_column($periods,'period')) === false){
                        $newp = new Period;
                        $newp->user_id = $request['user_id'];
                        $newp->period = $period;
                        $newp->expiration_date = $expdate;
                        $newp->available_days = $days;
                        $newp->save();
                        if($newp->save() == true){
                            $a++;
                        }
                    }else{
                        $a++;
                    }
                }else{
                    $des = true;
                }
            }catch(Exception $e){
                alert()->error($e);
                return back();
            }
        }
        if($a == $p){
            alert()->success('Se ha guardado el registro exitosamente');
            return redirect(route('holidays.createHoliday',$request['user_id']));
        }else{
            if(isset($des)){
                alert()->success('Se ha guardado el registro exitosamente');
                return redirect(route('holidays.createHoliday',$request['user_id']));
            }
            alert()->error('Ha ocurrido un error al guardar los datos');
            return back();
        }

    }
}
