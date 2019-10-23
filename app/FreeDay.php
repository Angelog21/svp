<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreeDay extends Model
{
    protected $fillable = [
        'date',
        'description'
    ];

    public static function getDaysInRange($fi,$ff){
        $days = FreeDay::whereBetween('date',[$fi,$ff])->count();
        return $days;
    }
}
