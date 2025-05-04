<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Complaint;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function generate(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30)->startOfDay());
        $endDate = $request->input('end_date', now()->endOfDay());

        $salesData = Order::whereBetween('orderDate', [$startDate, $endDate])
            ->select(
                DB::raw('SUM(totalAmount) as total_sales'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('AVG(totalAmount) as avg_order_value')
            )
            ->first();

        // Order Statistics
        $ordersByStatus = Order::whereBetween('orderDate', [$startDate, $endDate])
            ->groupBy('orderStatus')
            ->select('orderStatus', DB::raw('COUNT(*) as count'))
            ->pluck('count', 'orderStatus')
            ->all();

        $topCustomers = Order::whereBetween('orderDate', [$startDate, $endDate])
            ->join('account', 'orders.accountId', '=', 'account.accountId')
            ->groupBy('orders.accountId', 'account.fullName')
            ->select('account.fullName', DB::raw('SUM(totalAmount) as total_spent'))
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        // Complaint Trends
        $totalComplaints = Complaint::whereBetween('complaintDate', [$startDate, $endDate])->count();
        $complaintsByStatus = Complaint::whereBetween('complaintDate', [$startDate, $endDate])
            ->groupBy('status')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->pluck('count', 'status')
            ->all();

        $totalProducts = Product::count();
        $lowStockItems = Inventory::where('quantity', '<', 10)->count();
        $topSellingProducts = OrderItem::join('inventory', 'order_item.inventoryId', '=', 'inventory.inventoryId')
            ->join('product', 'inventory.productId', '=', 'product.productId')
            ->groupBy('product.productId', 'product.name')
            ->select('product.name', DB::raw('SUM(order_item.quantity) as total_sold'))
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return view('admin.reports', compact(
            'startDate', 'endDate',
            'salesData', 'ordersByStatus', 'topCustomers',
            'totalComplaints', 'complaintsByStatus',
            'totalProducts', 'lowStockItems', 'topSellingProducts'
        ));
    }
}
