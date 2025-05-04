<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Complaint;
use App\Models\Order;
use App\Models\Product;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = Account::count();
        $pendingOrders = Order::where('orderStatus', 'Pending')->count();
        $awaitingApproval = Order::where('orderStatus', 'Pending')->count();

        $totalComplaints = Complaint::count();
        $unresolvedComplaints = Complaint::where('status', '!=', 'Resolved')->count();

        $totalProducts = Product::count();
        $lowStockItems = Inventory::where('quantity', '<', 10)->count();

        $salesData = Order::select(
            DB::raw('MONTH(orderDate) as month'),
            DB::raw('SUM(totalAmount) as total')
        )
            ->where('orderDate', '>=', now()->subMonths(6))
            ->groupBy(DB::raw('MONTH(orderDate)'))
            ->orderBy('month')
            ->pluck('total', 'month')
            ->all();
        $salesLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $salesValues = array_fill(0, 6, 0);
        $startMonth = now()->subMonths(5)->month;
        foreach ($salesData as $month => $total) {
            $index = ($month - $startMonth + 12) % 12;
            $salesValues[$index] = $total;
        }
        $salesLabels = array_slice($salesLabels, $startMonth - 1, 6);
        return view('admin.dashboard', compact(
            'totalUsers',
            'pendingOrders', 'awaitingApproval',
            'totalComplaints', 'unresolvedComplaints',
            'totalProducts', 'lowStockItems',
            'salesLabels', 'salesValues',
        ));
    }
}
