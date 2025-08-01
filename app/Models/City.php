<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{


    protected $fillable = [
        'name',
        'country_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function users(){
        return $this->hasMany(User::class, 'city_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
