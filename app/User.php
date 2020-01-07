<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Trace;
use App\Role;
use App\Person;
use App\Period;
use App\Area;
use App\Direction;
use App\Office;
use Illuminate\Support\Facades\DB;
use App\Holiday;
use App\Permit;
use App\Notification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    const AVAILABLE = 'disponible';
    const PERMIT = 'de permiso';
    const HOLIDAY = 'de vacaciones';

    protected $fillable = [
        'person_id', 'username', 'email', 'password','role_id','state'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function stateUser(){
        $user_state = $this->state;
        if($user_state == User::AVAILABLE){
            return User::AVAILABLE;
        }elseif($user_state == User::PERMIT){
            return User::PERMIT;
        }else{
            return User::HOLIDAY;
        }
    }

    public static function roleUser(){
        return auth()->user()->role->name;
    }

    //relaciones

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function traces(){
        return $this->hasMany(Trace::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function periods(){
        return $this->hasMany(Period::class);
    }

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function direction(){
        return $this->belongsTo(Direction::class);
    }

    public function office(){
        return $this->belongsTo(Office::class);
    }

    public function holidays(){
        return $this->hasMany(Holiday::class);
    }

    public function permits(){
        return $this->hasMany(Permit::class);
    }

    public function logout(Request $request){
        auth()->logout();
        session()->flush();
        return redirect('/login');
    }

    public static function getApprover($id){
        if($id == 0){
            $approver = User::where('role_id',Role::DIRECTOR_LINEA)->where('direction_id',auth()->user()->office_id)->where('id','<>',auth()->user()->id)->get();
            if($approver->isEmpty()){
                $approver = User::where('role_id',Role::DIRECTOR_GENERAL)->where('office_id',auth()->user()->office_id)->get();
                if($approver->isEmpty()){
                    $approver = User::where('role_id',Role::SUPERADMIN)->get();
                }
            }
        }else{
            $user = User::where('id',$id)->get();
            $approver = User::where('role_id',Role::DIRECTOR_LINEA)->where('direction_id',$user[0]->office_id)->where('id','<>',$id)->get();
            if($approver->isEmpty()){
                $approver = User::where('role_id',Role::DIRECTOR_GENERAL)->where('office_id',$user[0]->office_id)->get();
                if($approver->isEmpty()){
                    $approver = User::where('role_id',Role::SUPERADMIN)->get();
                }
            }
        }
        return $approver;
    }

    public static function getSupervisor(){
        $supervisor_id = User::where('role_id',Role::SUPERVISOR)->where('area_id',auth()->user()->area_id)->get();
        if(!$supervisor_id->isEmpty()){
            return $supervisor_id;
        }
        return null;
    }

}
