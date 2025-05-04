<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $table = 'offer';
    protected $primaryKey = 'offerId';
    public $timestamps = false;

    protected $fillable = [
        'startDate', 'endDate', 'discountPercentage', 'inventoryId'
    ];

    // Relationships
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventoryId', 'inventoryId');
    }
}
