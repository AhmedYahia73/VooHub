<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'notification',
        'user_id',
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'notification_users', 'notification_id', 'user_id');
    }
}
