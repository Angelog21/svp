<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Role extends Model
{
    const ROOT = 1;
    const SUPERADMIN = 2;
    const DIRECTOR_GENERAL = 3;
    const DIRECTOR_LINEA = 4;
    const SUPERVISOR = 5;
    const ANALISTA_VACACIONES = 6;
    const ANALISTA_PERMISOS = 7;
    const EMPLEADO = 8;

    public function users(){
        return $this->hasMany(User::class);
    }
}
