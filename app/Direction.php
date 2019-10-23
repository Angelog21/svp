<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Office;
use App\Area;
use App\User;

class Direction extends Model
{
    protected $fillable = [
        'office_id',
        'name'
    ];

    public function office(){
        return $this->belongsTo(Office::class);
    }

    public function areas(){
        return $this->hasMany(Area::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

}
