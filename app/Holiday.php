<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Period;
use App\Office;

class Holiday extends Model
{
    const PROCESO = 'En proceso';
    const APROBADO = 'Aprobado';
    const RECHAZADO = 'Rechazado';
    const SUSPENDIDO = 'Suspendido';
    const FIRMADO = 'Firmado';
    const DISFRUTANDO = 'Disfrutando';
    const COMPLETO = 'Completo';

    protected $fillable = [
        'applicant_id',
        'supervisor_id',
        'approver_id',
        'office_id',
        'request_days',
        'enjoyed_days',
        'leftover_days',
        'start_date',
        'end_date',
        'refund_date',
        'observation',
        'state'
    ];

    public function periods(){
        return $this->belongsToMany(Period::class);
    }

    public function applicant(){
        return $this->belongsTo(User::class,'applicant_id');
    }

    public function approver(){
        return $this->belongsTo(User::class,'approver_id');
    }

    public function office(){
        return $this->belongsTo(Office::class);
    }

    public static function sumDay($date){
        $holiday = Holiday::where('start_date','<=',$date)->where('end_date','>=',$date)->increment('leftover_days');
        if($holiday > 0) return true;
    }
    public static function subsDay($date){
        $holiday = Holiday::where('start_date','<=',$date)->where('end_date','>=',$date)->decrement('leftover_days');
        if($holiday > 0) return true;
    }

}
