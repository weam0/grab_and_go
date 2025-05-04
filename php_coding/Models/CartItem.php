<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_item';
    protected $primaryKey = 'cartItemId';
    public $timestamps = false;

    protected $fillable = [
        'quantity', 'subtotalPrice', 'orderId', 'inventoryId'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId', 'orderId');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventoryId', 'inventoryId');
    }
}
