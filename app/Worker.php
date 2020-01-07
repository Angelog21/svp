<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Person;
use Illuminate\Support\Facades\Auth;

class Worker extends Model
{
    protected $fillable = [
        'name',
        'card_id',
        'extension',
        'phone',
        'date_admission'
    ];

    protected $connection = 'sige';
    protected $table = 'trabajador';

    public static function getDateAdmission(){
        return Auth::user()->person->date_admission;
    }

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }
}
