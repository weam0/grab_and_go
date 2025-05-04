<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'orderId';
    public $timestamps = false;

    protected $fillable = [
        'totalAmount', 'orderType', 'usedPoints', 'orderDate', 'orderStatus', 'accountId'
    ];

    // Relationships
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'orderId', 'orderId');
    }
    public function account()
    {
        return $this->belongsTo(Account::class, 'accountId', 'accountId');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'orderId', 'orderId');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'orderId', 'orderId');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'orderId', 'orderId');
    }
    public function lockerReservation()
    {
        return $this->hasMany(LockerReservation::class, 'orderId', 'orderId');
    }
}
