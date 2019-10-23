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

    public static function getPeriod($id){
        $period = Period::where('id',$id)->get();
        return $period[0]->original;
    }

}
