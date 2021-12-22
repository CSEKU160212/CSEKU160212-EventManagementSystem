<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventComment extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table = 'event_comments'; 
        
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'comment',
        'eventid',
        'userid',
    ];
    
    /**
     * user
     *
     * @return void
     */
    public function event()
    {
        return $this->belongsTo('Event', 'eventid');
    }
    
    /**
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'userid');
    }
}
