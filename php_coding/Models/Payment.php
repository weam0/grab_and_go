<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

    protected $primaryKey = 'paymentId';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'paymentId',
        'paymentMethod',
        'cardNumber',
        'cardExpiryDate',
        'transactionStatus',
        'paymentDate',
        'orderId',
    ];
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId', 'orderId');
    }
}
