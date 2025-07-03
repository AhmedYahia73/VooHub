<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

use Carbon\Carbon;

class User extends Model
{
    use HasApiTokens;

    protected $fillable =[
        'country_id',
        'city_id',
        'name',
        'email',
        'password',
        'phone',
        'birth',
        'gender',
        'total_hours',
        'total_events',
        'avatar_image',
        'orgnization',
        'is_email_verified',
        'email_verification_code',
        'account_status',
        'role',
        'orgnization_id',
        'total_tasks'
    ]; 

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'avatar_image_link',
        'month',
        'year',
        'age'
    ];

    public function getAgeAttribute(){
        if (!empty($this->birth)) {
            return Carbon::parse($this->birth)->age;
        }
        return null;
    }

    public function getMonthAttribute(){
        return \Carbon\Carbon::parse($this->created_at)->format('m');
    }

    public function getYearAttribute(){
        return \Carbon\Carbon::parse($this->created_at)->format('Y');
    }

    public function getAvatarImageLinkAttribute(){
        if(isset($this->attributes['avatar_image'])){
            return asset('storage/'.$this->attributes['avatar_image']);
        }
        return null;
    }


    // public function events()
    // {
    //     return $this->belongsToMany(Event::class);
    // }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function projects()
    {
        return $this->hasMany(OrganizationProject::class, 'organiztion_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function event_volunteers()
    {
        return $this->hasMany(EventVolunteer::class);
    }

    public function user_papers()
    {
        return $this->hasMany(UserPaper::class);
    }

    public function orgnization()
    {
        return $this->belongsTo(User::class,'orgnization_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class,'orgnization_id');
    }

    public function event_user()
    {
        return $this->belongsToMany(Event::class,'event_users');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class,'orgnization_id');
    }

    public function user_events()
    {
        return $this->belongsToMany(Event::class,'event_volunteers')
        ->wherePivot('status', 'attend');
    }

    public function user_tasks()
    {
        return $this->belongsToMany(Task::class,'task_volunteers')
        ->wherePivot('status', 'attend');
    }
}
