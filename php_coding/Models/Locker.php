<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    protected $table = 'locker';
    protected $primaryKey = 'lockerId';
    public $timestamps = false;

    protected $fillable = [
        'lockerNumber', 'location', 'size', 'status'
    ];

    // Relationships
    public function lockerReservations()
    {
        return $this->hasMany(LockerReservation::class, 'lockerId', 'lockerId');
    }
}
