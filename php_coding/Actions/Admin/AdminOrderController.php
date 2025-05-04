<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function orders()
    {
        $orders = Order::with('account')->latest('orderDate')->get();
        return view('admin.orders', compact('orders'));
    }

    public function orderDetails($orderId)
    {
        $order = Order::with(['account', 'orderItems.inventory.product', 'payment'])->findOrFail($orderId);
        return view('admin.order-details', compact('order'));
    }
}
