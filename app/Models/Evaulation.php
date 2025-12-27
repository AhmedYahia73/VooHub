<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaulation extends Model
{
    protected $fillable =[
        'name',
        'title',
        'image',
        'evaulation',
    ];

    protected $appends = [
        'image_link'
    ];

    public function getImageLinkAttribute(){
        if(isset($this->attributes['image'])){
            return asset('storage/'.$this->attributes['image']);
        }
        return null;
    }
}
