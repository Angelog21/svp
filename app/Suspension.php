<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suspension extends Model
{
    protected $fillable = [
        'employee_id',
        'supervisor_id',
        'suspension_date',
        'refund_date',
        'leftover_days',
        'reason'
    ];

}
