<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class SmartCartSimulationController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $inventoryId => $quantity) {
            $inventory = Inventory::with(['product', 'offers'])->find($inventoryId);
            if ($inventory) {
                $cartItems[] = [
                    'inventory' => $inventory,
                    'quantity' => $quantity,
                    'subtotal' => $inventory->price * $quantity,
                ];
                $total += $inventory->price * $quantity;
            }
        }

        return view('customer.smart-cart-simulation', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $barcode = $request->input('barcode');
        $inventory = Inventory::where('barcode', $barcode)->first();

        if (!$inventory) {
            return redirect()->route('smart-cart-simulation')->with('error', 'Invalid or unknown barcode.');
        }

        $cart = session()->get('simulation_cart', []);

        if (isset($cart[$inventory->inventoryId])) {
            $cart[$inventory->inventoryId] += 1;
        } else {
            $cart[$inventory->inventoryId] = 1;
        }

        session()->put('cart', $cart);

        return redirect()->route('smart-cart-simulation')->with('success', 'Item added to simulated cart!');
    }

    public function remove($inventoryId)
    {
        $cart = session()->get('simulation_cart', []);

        if (isset($cart[$inventoryId])) {
            unset($cart[$inventoryId]);
            session()->put('simulation_cart', $cart);
        }

        return redirect()->route('smart-cart-simulation')->with('success', 'Item removed from simulated cart!');
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

        return redirect()->route('smart-cart-simulation')->with('success', 'Quantity updated in simulated cart!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('smart-cart-simulation')->with('success', 'Simulated cart cleared!');
    }

    public function addByBarcode(Request $request)
    {
        $barcode = $request->input('barcode');
        $inventory = Inventory::where('barcode', $barcode)->first();
        if (!$inventory) {
            return redirect()->back()->with('error', 'Product not found for scanned barcode.');
        }
        $cart = session()->get('cart', []);
        if (isset($cart[$inventory->inventoryId])) {
            $cart[$inventory->inventoryId]++;
        } else {
            $cart[$inventory->inventoryId] = 1;
        }
        session()->put('cart', $cart);
        session()->flash('scannedProduct', $inventory);

        return redirect()->back()->with('success', 'Product added to Smart Cart!');
    }

}
