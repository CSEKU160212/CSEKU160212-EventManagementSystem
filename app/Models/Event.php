<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table = 'events'; 
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'organized_by',
        'venue',
        'event_start_date',
        'event_length',
        'reg_start_date',
        'reg_end_date',
        'description',
        'userid',
    ];
    
    /**
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('User');
    }
    
    /**
     * eventOptions
     *
     * @return void
     */
    public function eventOptions()
    {
        return $this->hasMany('EventOption', 'id', 'eventid',);
    }
        
    /**
     * eventComments
     *
     * @return void
     */
    public function eventComments()
    {
        return $this->hasMany('EventComment', 'eventid', 'id');
    }
    
    /**
     * eventRegisteredUser
     *
     * @return void
     */
    public function eventRegisteredUser()
    {
        return $this->hasMany('EventComment', 'eventid', 'id');
    }
}
