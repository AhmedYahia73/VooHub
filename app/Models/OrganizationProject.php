<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationProject extends Model
{
    protected $fillable = [
        'name',
        'description',
        'organiztion_id',
    ];
}
