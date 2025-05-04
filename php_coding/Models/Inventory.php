<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';
    protected $primaryKey = 'inventoryId';
    public $timestamps = false;

    protected $fillable = [
        'productId', 'barcode', 'quantity', 'price', 'size', 'weight', 'expiryDate', 'batchNumber',
        'lastUpdate', 'shelfLocation', 'imageUrl'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class, 'productId', 'productId');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'inventoryId', 'inventoryId');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'inventoryId', 'inventoryId');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'inventoryId', 'inventoryId');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'inventoryId', 'inventoryId');
    }

    public function stockShelves()
    {
        return $this->hasMany(StockShelf::class, 'inventoryId', 'inventoryId');
    }
}
