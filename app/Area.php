<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Direction;
use App\User;

class Area extends Model
{
    protected $fillable = ['office_id','name'];

    public function direction(){
        return $this->belongsTo(Direction::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

}
