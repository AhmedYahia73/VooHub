<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskVolunteer extends Model
{


    protected $fillable = [
        'task_id',
        'user_id',
        'status',
        'hours',
        'qr_code',
    ];
    protected $appends = ['qr_code_link'];

    public function getQrCodeLinkAttribute(){
        return url('storage/' . $this->qr_code);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
