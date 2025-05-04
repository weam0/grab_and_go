<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Inventory;
use App\Models\LockerReservation;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure user is logged in
    }

    public function home()
    {
        $recentOrders = Order::where('accountId', Auth::id())
            ->latest('orderDate')
            ->take(3)
            ->get();
        $popularProducts = Inventory::with('product')
            ->join('order_item', 'inventory.inventoryId', '=', 'order_item.inventoryId')
            ->select('inventory.*')
            ->selectRaw('SUM(order_item.quantity) as total_sold')
            ->groupBy('inventory.inventoryId')
            ->orderByDesc('total_sold')
            ->take(4)
            ->get();
        $totalOrders = Order::where('accountId', Auth::id())->count();
        $totalPoints = Auth::user()->rewardPoints ?? 0;
        return view('customer.dashboard', compact('recentOrders', 'popularProducts', 'totalOrders', 'totalPoints'));
    }

    public function profile()
    {
        return view('customer.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'fullName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:account,email,' . $user->accountId . ',accountId',
            'phoneNumber' => 'nullable|string|max:20',
            'accountType' => 'nullable|string|in:customer,admin', // Assuming accountType is restricted
            'rewardPoints' => 'nullable|integer|min:0',
            'lockerNumber' => 'nullable|string|max:50',
        ]);

        $user->update([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber ?? $user->phoneNumber,
            'accountType' => $request->accountType ?? $user->accountType,
            'rewardPoints' => $request->rewardPoints ?? $user->rewardPoints,
            'lockerNumber' => $request->lockerNumber ?? $user->lockerNumber,
        ]);

        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully!');
    }

    public function password()
    {
        return view('customer.password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('customer.password')->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('customer.password')->with('success', 'Password updated successfully!');
    }

    public function orders()
    {
        $orders = Order::where('accountId', Auth::id())->latest('orderDate')->paginate(10);
        return view('customer.orders', compact('orders'));
    }

    public function showOrder($orderId)
    {
        $order = Order::where('accountId', Auth::id())->findOrFail($orderId);
        return view('customer.order-details', compact('order'));
    }

    public function storeComplaint(Request $request)
    {
        $request->validate([
            'orderId' => 'required|exists:orders,orderId',
            'description' => 'required|string|max:1000',
        ]);

        // Ensure the order belongs to the authenticated user
        $order = Order::where('accountId', Auth::id())->findOrFail($request->orderId);

        Complaint::create([
            'accountId' => Auth::id(),
            'orderId' => $order->orderId,
            'description' => $request->description,
            'complaintDate' => now(),
            'status' => 'Pending',
            'reply' => null,
        ]);

        return redirect()->route('customer.orders')->with('success', 'Complaint submitted successfully!');
    }

    public function complaints()
    {
        $complaints = Complaint::where('accountId', Auth::id())->latest('complaintDate')->paginate(10);
        return view('customer.complaints', compact('complaints'));
    }

    public function smartCart(Request $request)
    {
        $query = Inventory::with(['product', 'offers'])->where('quantity', '>', 0);

        if ($request->has('search') && !empty($request->search)) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $inventoryItems = $query->paginate(12);

        return view('customer.smart-cart', compact('inventoryItems'));
    }

    public function addToSmartCart(Request $request, $inventoryId)
    {
        $inventory = Inventory::findOrFail($inventoryId);
        $smartCart = session()->get('cart', []);

        if (isset($smartCart[$inventoryId])) {
            $smartCart[$inventoryId] += 1;
        } else {
            $smartCart[$inventoryId] = 1;
        }

        session()->put('cart', $smartCart);

        return redirect()->route('customer.smart-cart')->with('success', 'Item added to smart cart successfully!');
    }
    public function storeReview(Request $request)
    {
        $request->validate([
            'inventoryId' => 'required|exists:inventory,inventoryId',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
            'product_quality_rating' => 'required|integer|between:1,5',
            'order_accuracy_rating' => 'required|integer|between:1,5',
            'locker_condition_rating' => 'required|integer|between:1,5',
            'processing_speed_rating' => 'required|integer|between:1,5',
        ]);

        if (Review::where('accountId', Auth::id())->where('inventoryId', $request->inventoryId)->exists()) {
            return redirect()->back()->withErrors(['comment' => 'You have already reviewed this product.']);
        }

        Review::create([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'reviewDate' => now(),
            'accountId' => Auth::id(),
            'inventoryId' => $request->inventoryId,
            'product_quality_rating' => $request->product_quality_rating,
            'order_accuracy_rating' => $request->order_accuracy_rating,
            'locker_condition_rating' => $request->locker_condition_rating,
            'processing_speed_rating' => $request->processing_speed_rating,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }


    public function deleteReview($reviewId)
    {
        $review = Review::where('accountId', Auth::id())->findOrFail($reviewId);
        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully!');
    }

    public function lockers()
    {
        $reservations = LockerReservation::with('locker')
            ->where('accountId', Auth::id())
            ->orderBy('reservationStart', 'desc')
            ->get();

        return view('customer.lockers', compact('reservations'));
    }
}

