<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Locker;
use App\Models\LockerReservation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $inventoryId => $quantity) {
            $inventory = Inventory::with('product')->find($inventoryId);
            if ($inventory) {
                $price = $inventory->price;
                $hasOffer = $inventory->offers->isNotEmpty() && now()->between($inventory->offers->first()->startDate, $inventory->offers->first()->endDate);
                if ($hasOffer) {
                    $price = $inventory->price;
                }
                $cartItems[] = [
                    'inventory' => $inventory,
                    'quantity' => $quantity,
                    'subtotal' => $price * $quantity,
                ];
                $total += $price * $quantity;
            }
        }

        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty. Add items before checking out.');
        }
        $availableLockers = Locker::where('status', 'Available')->get();
        return view('customer.checkout', compact('cartItems', 'total', 'availableLockers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paymentMethod' => 'required|string|in:Credit Card,Cash',
            'username' => 'required_if:paymentMethod,Credit Card|string|max:255',
            'cardNumber' => 'required_if:paymentMethod,Credit Card|string|size:16',
            'cardExpiryDate' => 'required_if:paymentMethod,Credit Card|date_format:m/y|after:today',
            'cvv' => 'required_if:paymentMethod,Credit Card|string|size:3',
            'lockerId' => 'nullable|exists:locker,lockerId',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        $cartItems = [];

        foreach ($cart as $inventoryId => $quantity) {
            $inventory = Inventory::find($inventoryId);
            if ($inventory) {
                $price = $inventory->price;
                $hasOffer = $inventory->offers->isNotEmpty() && now()->between($inventory->offers->first()->startDate, $inventory->offers->first()->endDate);
                if ($hasOffer) {
                    $price = $inventory->price;
                }
                $subtotal = $price * $quantity;
                $total += $subtotal;
                $cartItems[$inventoryId] = [
                    'quantity' => $quantity,
                    'soldPrice' => $price,
                ];
            }
        }
        $order = Order::create([
            'totalAmount' => $total,
            'orderType' => 'online',
            'usedPoints' => 0,
            'orderDate' => now(),
            'orderStatus' => 'Completed',
            'accountId' => Auth::id(),
        ]);
        foreach ($cartItems as $inventoryId => $item) {
            OrderItem::create([
                'quantity' => $item['quantity'],
                'soldPrice' => $item['soldPrice'],
                'orderId' => $order->orderId,
                'inventoryId' => $inventoryId,
            ]);
        }
        $payment = Payment::create([
            'paymentMethod' => $request->paymentMethod,
            'cardNumber' => $request->paymentMethod === 'Credit Card' ? substr($request->cardNumber, -4) : null,
            'cardExpiryDate' => $request->paymentMethod === 'Credit Card' ? $request->cardExpiryDate : null,
            'transactionStatus' => $request->paymentMethod === 'Cash' ? 'Pending' : 'Completed', // Cash pending until delivery
            'paymentDate' => now(),
            'orderId' => $order->orderId,
        ]);
        if ($request->filled('lockerId')) {
            LockerReservation::create([
                'accountId' => Auth::id(),
                'lockerId' => $request->lockerId,
                'reservationStart' => now(),
                'reservationEnd' => now()->addHours(24),
                'status' => 'Active',
            ]);

            Locker::where('lockerId', $request->lockerId)->update(['status' => 'Occupied']);
        }
        session()->forget('cart');
        return redirect()->route('customer.orders')->with('success', 'Order placed successfully! Order ID: #' . $order->orderId);
    }
}
