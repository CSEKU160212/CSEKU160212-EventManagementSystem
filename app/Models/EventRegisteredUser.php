<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegisteredUser extends Model
{    
    /**
     * table
     *
     * @var string
     */
    protected $table = 'event_registered_members';   
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'optionid',
        'userid',
        'transactionid',
        'is_approved',
    ];
    
    /**
     * eventOption
     *
     * @return void
     */
    public function eventOption()
    {
        return $this->belongsTo('EventOption', 'optionid', 'id');
    }
    
    /**
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('User', 'userid', 'id');
    }

}
