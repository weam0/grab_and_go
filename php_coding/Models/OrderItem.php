<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_item';
    protected $primaryKey = 'orderItemId';
    public $timestamps = false;

    protected $fillable = [
        'quantity', 'soldPrice', 'orderId', 'inventoryId'
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId', 'orderId');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventoryId', 'inventoryId');
    }
}
