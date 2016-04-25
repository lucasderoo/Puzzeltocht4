<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trips extends Model
{
   protected $fillable=[
        'tripname',
        'assignmentid'
    ];
    protected $table = 'trips';
}
