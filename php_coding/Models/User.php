<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  \Illuminate\Foundation\Auth\User as AuthUser;

class User extends AuthUser
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = [
        'email', 'password', 'name', 'profile_picture', 'status', 'date_created', 'last_login', 'role'
    ];

    public function researcher()
    {
        return $this->hasOne(Researcher::class, 'user_id');
    }

    public function generalUser()
    {
        return $this->hasOne(GeneralUser::class, 'user_id');
    }

    public function administrator()
    {
        return $this->hasOne(Administrator::class, 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'generated_by');
    }
}
