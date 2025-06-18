<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    protected $fillable =[
        'event_id',
        'count',
    ];
}
