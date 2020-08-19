<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegisteredUser extends Model
{
    protected $table = 'event_registered_member';   

    protected $fillable = [
        'optionid',
        'userid',
        'transactionid',
        'is_approved',
    ];

}
