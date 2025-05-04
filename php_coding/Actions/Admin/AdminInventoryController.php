<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Traits\UploadFile;
use Illuminate\Http\Request;

class AdminInventoryController extends Controller
{
    use UploadFile;

    public function index()
    {
        $inventories = Inventory::with('product')->get();
        return view('admin.inventories.index', compact('inventories'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.inventories.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:product,productId',
            'barcode' => 'required|string|max:255|unique:inventory,barcode',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'expiryDate' => 'nullable|date',
            'batchNumber' => 'nullable|string|max:100',
            'lastUpdate' => 'nullable|date',
            'shelfLocation' => 'nullable|string|max:100',
            'imageUrl' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'productId', 'barcode', 'quantity', 'price', 'size', 'weight', 'expiryDate', 'batchNumber', 'lastUpdate', 'shelfLocation'
        ]);

        if ($request->hasFile('imageUrl')) {
            $data['imageUrl'] = $this->upload($request->file('imageUrl'), 'uploads/inventories', $request->barcode);
        }

        Inventory::create($data);

        return redirect()->route('admin.inventories.index')->with('success', 'Inventory item created successfully!');
    }

    public function show(Inventory $inventory)
    {
        $inventory->load('product');
        return view('admin.inventories.show', compact('inventory'));
    }

    public function edit(Inventory $inventory)
    {
        $products = Product::all();
        return view('admin.inventories.edit', compact('inventory', 'products'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'productId' => 'required|exists:product,productId',
            'barcode' => 'required|string|max:255|unique:inventory,barcode,' . $inventory->inventoryId . ',inventoryId',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'expiryDate' => 'nullable|date',
            'batchNumber' => 'nullable|string|max:100',
            'lastUpdate' => 'nullable|date',
            'shelfLocation' => 'nullable|string|max:100',
            'imageUrl' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'productId', 'barcode', 'quantity', 'price', 'size', 'weight', 'expiryDate', 'batchNumber', 'lastUpdate', 'shelfLocation'
        ]);

        if ($request->hasFile('imageUrl')) {
            if ($inventory->imageUrl && file_exists(public_path($inventory->imageUrl))) {
                unlink(public_path($inventory->imageUrl));
            }
            $data['imageUrl'] = $this->upload($request->file('imageUrl'), 'uploads/inventories', $request->barcode);
        }

        $inventory->update($data);

        return redirect()->route('admin.inventories.index')->with('success', 'Inventory item updated successfully!');
    }

    public function destroy(Inventory $inventory)
    {
        if ($inventory->imageUrl && file_exists(public_path($inventory->imageUrl))) {
            unlink(public_path($inventory->imageUrl));
        }
        $inventory->delete();
        return redirect()->route('admin.inventories.index')->with('success', 'Inventory item deleted successfully!');
    }
}
