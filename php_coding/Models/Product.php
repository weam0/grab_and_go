<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'productId';
    public $timestamps = false;

    protected $fillable = [
        'name', 'description', 'imageUrl', 'categoryId'
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'categoryId');
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'productId', 'productId');
    }
}
