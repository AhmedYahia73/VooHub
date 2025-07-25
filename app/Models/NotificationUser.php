<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    protected $fillable = [
        'notification_id',
        'user_id',
        'read_status',
    ];

    public function notification(){
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}
