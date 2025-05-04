<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use  \Illuminate\Foundation\Auth\User as AuthUser;

class Account extends AuthUser
{
    protected $table = 'account';
    protected $primaryKey = 'accountId';
    public $timestamps = false;

    protected $fillable = [
        'fullName', 'email', 'phoneNumber', 'password', 'accountType', 'rewardPoints', 'lockerNumber'
    ];

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class, 'accountId', 'accountId');
    }

    public function lockerReservations()
    {
        return $this->hasMany(LockerReservation::class, 'accountId', 'accountId');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'accountId', 'accountId');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'accountId', 'accountId');
    }
}
