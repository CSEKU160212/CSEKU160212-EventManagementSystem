<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventOption extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table = 'event_options'; 
        
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'time',
        'place',
        'eventid',
        'fee',
    ];
    
    /**
     * event
     *
     * @return void
     */
    public function event()
    {
        return $this->belongsTo('App\Models\Event', 'eventid');
    }

    public function eventRegisteredUser()
    {
        return $this->hasMany('App\Models\EventRegisteredUser', 'id', 'optionid');
    }
}
