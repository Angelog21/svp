<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Notification extends Model
{
    //respuesta al solicitante
    const SOLICITUD_VACACIONES = 'Ha solicitado Vacaciones';
    const SOLICITUD_PERMISO = 'Ha solicitado Permiso';
    const APROBACION_VACACIONES = 'Ha aprobado sus Vacaciones';
    const APROBACION_PERMISO = 'Ha aprobado Permiso';
    const RECHAZO_VACACIONES = 'Ha rechazado sus Vacaciones';
    const RECHAZO_PERMISO = 'Ha rechazado Permiso';
    const SUSPENSION_VACACIONES = 'Ha suspendido sus Vacaciones';
    //respuesta al supervisor
    const APROBADA = 'Ha aprobado la solicitud de ';
    const RECHAZADA = 'Ha rechazado la solicitud de ';
    const SUSPENDIDA = 'Ha suspendido las vacaciones de ';

    protected $fillable = [
        'origin_id',
        'destination_id',
        'title',
        'description'
    ];

    public function origin(){
        return $this->belongsTo(User::class,'origin_id');
    }

    public function destination(){
        return $this->belongsTo(User::class,'destination_id');
    }
}
