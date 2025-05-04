<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\StockShelf;
use Illuminate\Http\Request;

class StockShelfController extends Controller
{
    public function index()
    {
        $shelves = StockShelf::with('inventory.product')->get();
        return view('admin.stock_shelves.index', compact('shelves'));
    }

    public function create()
    {
        $inventories = Inventory::with('product')->get();
        return view('admin.stock_shelves.create', compact('inventories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'inventoryId' => 'required|exists:inventory,inventoryId',
        ]);

        StockShelf::create($request->all());
        return redirect()->route('admin.stock-shelves.index')->with('success', 'Stock shelf added successfully.');
    }

    public function edit(StockShelf $stockShelf)
    {
        $inventories = Inventory::with('product')->get();
        return view('admin.stock_shelves.edit', compact('stockShelf', 'inventories'));
    }

    public function update(Request $request, StockShelf $stockShelf)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'inventoryId' => 'required|exists:inventory,inventoryId',
        ]);

        $stockShelf->update($request->all());
        return redirect()->route('admin.stock-shelves.index')->with('success', 'Stock shelf updated successfully.');
    }

    public function destroy(StockShelf $stockShelf)
    {
        $stockShelf->delete();
        return redirect()->route('admin.stock-shelves.index')->with('success', 'Stock shelf deleted.');
    }
}
