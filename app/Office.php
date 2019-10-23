<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Direction;
use App\Holiday;

class Office extends Model
{
    protected $fillable = [
        'name',
        'acronimo'
    ];

    public function directions(){
        return $this->hasMany(Direction::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function holidays(){
        return $this->hasMany(Holiday::class);
    }
}
