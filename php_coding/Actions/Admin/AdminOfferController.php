<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Inventory;
use Illuminate\Http\Request;

class AdminOfferController extends Controller
{
    public function index()
    {
        $offers = Offer::with('inventory')->get();
        return view('admin.offers.index', compact('offers'));
    }

    public function create()
    {
        $inventories = Inventory::all();
        return view('admin.offers.create', compact('inventories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate',
            'discountPercentage' => 'required|numeric|min:0|max:100',
            'inventoryId' => 'required|exists:inventory,inventoryId',
        ]);

        Offer::create($request->only([
            'startDate', 'endDate', 'discountPercentage', 'inventoryId'
        ]));

        return redirect()->route('admin.offers.index')->with('success', 'Offer created successfully!');
    }

    public function show(Offer $offer)
    {
        $offer->load('inventory');
        return view('admin.offers.show', compact('offer'));
    }

    public function edit(Offer $offer)
    {
        $inventories = Inventory::all();
        return view('admin.offers.edit', compact('offer', 'inventories'));
    }

    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate',
            'discountPercentage' => 'required|numeric|min:0|max:100',
            'inventoryId' => 'required|exists:inventory,inventoryId',
        ]);

        $offer->update($request->only([
            'startDate', 'endDate', 'discountPercentage', 'inventoryId'
        ]));

        return redirect()->route('admin.offers.index')->with('success', 'Offer updated successfully!');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('admin.offers.index')->with('success', 'Offer deleted successfully!');
    }
}
