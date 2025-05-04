<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LockerReservation extends Model
{
    protected $table = 'locker_reservation';
    protected $primaryKey = 'reservationId';
    public $timestamps = false;

    protected $fillable = [
        'accountId', 'lockerId', 'reservationStart', 'reservationEnd', 'status'
    ];

    // Relationships
    public function account()
    {
        return $this->belongsTo(Account::class, 'accountId', 'accountId');
    }

    public function locker()
    {
        return $this->belongsTo(Locker::class, 'lockerId', 'lockerId');
    }
}
