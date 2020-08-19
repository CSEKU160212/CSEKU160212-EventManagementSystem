<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events'; 

    protected $fillable = [
        'title',
        'organized_by',
        'venue',
        'event_start_date',
        'event_length',
        'registration_start_date',
        'registration_end_date',
        'description',
        'userid',
    ];

}
