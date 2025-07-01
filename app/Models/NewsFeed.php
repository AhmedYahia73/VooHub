<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsFeed extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'image',
        'video',
    ];
    protected $appends = ['image_link', 'video_link'];

    public function getImageLinkAttribute(){
        if (!empty($this->image)) {
            return url('storage/', $this->image);
        }
        return null;
    }

    public function getVideoLinkAttribute(){
        if (!empty($this->video)) {
            return url('storage/', $this->video);
        }
        return null;
    }
}
