<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventComment extends Model
{
    protected $table = 'event_comments'; 
    
    protected $fillable = [
        'comment',
        'time',
        'eventid',
        'userid',
    ];
}
