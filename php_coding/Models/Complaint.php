<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table = 'complaint';
    protected $primaryKey = 'complaintId';
    public $timestamps = false;

    protected $fillable = [
        'accountId', 'orderId', 'description', 'complaintDate', 'status', 'reply'
    ];

    // Relationships
    public function account()
    {
        return $this->belongsTo(Account::class, 'accountId', 'accountId');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId', 'orderId');
    }
}
