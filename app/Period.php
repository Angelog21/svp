<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Holiday;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Period extends Model
{
    protected $fillable = [
        'user_id',
        'period',
        'expiration_date',
        'available_days'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function holidays(){
        return $this->belongsToMany(Holiday::class);
    }

    public static function getAvailablePeriod($rd){
        $periods = [];
        $i = 1;
        $fp = Period::where('user_id',auth()->user()->id)->where('available_days','<>',0)->orderBy('id','ASC')->value('available_days');
        if(!$fp){
            return null;
        }
        do{
            if($rd > $fp){
                if($rd > 30){
                    $rd -= 30;
                    $i++;
                }else{
                    $rd -= $fp;
                    $fp = 30;
                    $i++;

                }
            }elseif($rd <= 30){
                $periods = Period::where('user_id',auth()->user()->id)->where('available_days','<>',0)->orderBy('id','ASC')->limit($i)->get();
                $rd = 0;
            }
        }while($rd > 0);
        return $periods;
    }

    public static function validatePeriod(){
        $period = Period::where('user_id',auth()->user()->id)->get(['id','period'])->last();
        $yearact = date('Y');
        $year2 = Carbon::now()->addYear()->format('Y');
        $newPeriod = $yearact . '-' . $year2;
        if($period['period'] !== $newPeriod){
            return true;
        }
        return $period['id'];
    }

    public static function getAvailableDays(){
        return auth()->user()->periods->sum('available_days');
    }

    public static function getAvailableDaysByUser($id){
        $u = User::findOrFail($id);
        return $u->periods->sum('available_days');
    }

    public static function getPeriod($id){
        $period = Period::where('id',$id)->get();
        return $period[0]->original;
    }

    public static function getFirstsPeriods($user_id){
        //se obtendrá la fecha de inicio
        $user = User::where('id',$user_id)->with('person')->get();
        $date_admission = $user[0]->person->date_admission;
        $year = substr($date_admission,0,4);
        $date = date('Y').substr($date_admission,4);
        $periods = [];
        //obtener el año de la fecha de inicio y mientras sea menor o igual al año actual incrementará
        while($year <= date('Y')){
            if($year == date('Y')){
                if($date > date('Y-m-d')){
                    break;
                }else{
                    $nyear = $year+1;
                    $name = $year."-".$nyear;
                    $expiration_date = $year.substr($date,4);
                    $periods[$name] = $expiration_date;
                    $year++;
                }
            }else{
                $nyear = $year+1;
                $name = $year."-".$nyear;
                $expiration_date = $year.substr($date,4);
                $periods[$name] = $expiration_date;
                $year++;
            }
        }
        return $periods;
    }
}
