<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    protected $primaryKey = 'reviewId';
    public $timestamps = false;

    protected $fillable = [
        'rating', 'comment', 'reviewDate', 'accountId',
        'inventoryId',
        'product_quality_rating',
        'order_accuracy_rating',
        'locker_condition_rating',
        'processing_speed_rating',
    ];

    // Relationships
    public function account()
    {
        return $this->belongsTo(Account::class, 'accountId', 'accountId');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventoryId', 'inventoryId');
    }
}
