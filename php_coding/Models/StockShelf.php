<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockShelf extends Model
{
    protected $table = 'stock_shelf';
    protected $primaryKey = 'stockShelfId';
    public $timestamps = false;

    protected $fillable = [
        'location', 'quantity', 'inventoryId'
    ];

    // Relationships
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventoryId', 'inventoryId');
    }
}
