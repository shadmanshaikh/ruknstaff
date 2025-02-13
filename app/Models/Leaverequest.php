<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leaverequest extends Model
{
    protected $fillable = [
        'from' , 'to' , 'reason' , 'description'
    ];
}
