<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Employee;
use App\Supervisor;
use App\LineDirector;
use App\ManagingDirector;

class Permit extends Model
{
    const APROBADO = 'Aprobado';
    const RECHAZADO = 'Rechazado';
    const PROCESO = 'En proceso';
    const COMPLETO = 'Completo';

    protected $fillable = [
        'applicant_id',
        'supervisor_id',
        'office_id',
        'start_date',
        'end_date',
        'refund_date',
        'reason_id',
        'days',
        'turn',
        'remunerate',
        'substitute_require',
        'description',
        'observation',
        'state'
    ];

    public function statePermit(){
        $state = $this->state;
        if($state == Permit::VISTO){
            return Permit::VISTO;
        }elseif($state == Permit::APROBADO){
            return Permit::APROBADO;
        }elseif($state == Permit::RECHAZADO){
            return Permit::RECHAZADO;
        }else{
            return Permit::PROCESO;
        }
    }

    public function applicant(){
        return $this->belongsTo(User::class,'applicant_id');
    }

    public function supervisor(){
        return $this->belongsTo(User::class,'supervisor_id');
    }

    public function reason(){
        return $this->belongsTo(Reason::class);
    }
}
