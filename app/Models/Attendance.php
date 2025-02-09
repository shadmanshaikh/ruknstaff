<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'date', 'user','punchin', 'punchout' , 'leave' , 'longitude' , 'latitude' 
    ];
}
