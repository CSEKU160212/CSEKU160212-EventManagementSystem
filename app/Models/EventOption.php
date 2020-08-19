<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventOption extends Model
{
    protected $table = 'event_options'; 
    
    protected $fillable = [
        'title',
        'time',
        'place',
        'eventid',
        'fee',
    ];
}
