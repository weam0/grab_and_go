<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $inventoryId => $quantity) {
            $inventory = Inventory::with('product')->find($inventoryId);
            if ($inventory) {
                $cartItems[] = [
                    'inventory' => $inventory,
                    'quantity' => $quantity,
                    'subtotal' => $inventory->price * $quantity,
                ];
                $total += $inventory->price * $quantity;
            }
        }

        return view('customer.cart', compact('cartItems', 'total'));
    }

    public function add(Request $request, $inventoryId)
    {
        $inventory = Inventory::findOrFail($inventoryId);
        $cart = session()->get('cart', []);

        if (isset($cart[$inventoryId])) {
            $cart[$inventoryId] += 1;
        } else {
            $cart[$inventoryId] = 1;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Item added to cart successfully!');
    }

    public function remove($inventoryId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$inventoryId])) {
            unset($cart[$inventoryId]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Item removed from cart successfully!');
    }

    public function update(Request $request, $inventoryId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$inventoryId])) {
            $cart[$inventoryId] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart')->with('success', 'Cart updated successfully!');
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        return array_sum($cart);
    }
}
