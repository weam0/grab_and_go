<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function home()
    {
        $inventoryItems = Inventory::with(['product', 'offers'])
            ->where('quantity', '>', 0)
            ->take(8)
            ->get();

        return view('customer.home', compact('inventoryItems'));
    }

    public function shop(Request $request)
    {
        $categories = Category::all();
        $query = Inventory::with(['product.category', 'offers', 'reviews'])
            ->where('quantity', '>', 0);
        if ($request->has('search')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('categoryId', $request->category);
            });
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popularity':
                    $query->orderBy('quantity', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
            }
        }

        if ($request->has('offers') && $request->offers) {
            $query->whereHas('offers', function ($q) {
                $q->where('endDate', '>=', now())
                    ->where('startDate', '<=', now());
            });
        }
        if ($request->has('rating')) {
            $query->whereHas('reviews', function ($q) use ($request) {
                $q->havingRaw('AVG(rating) >= ?', [$request->rating]);
            })->withCount(['reviews as avg_rating' => function ($q) {
                $q->selectRaw('AVG(rating)');
            }]);
        }
        $inventories = $query->paginate(9);
        $featuredProducts = Inventory::with(['product', 'offers'])
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('customer.shop', compact('categories', 'inventories', 'featuredProducts'));
    }

    public function showProduct($inventoryId)
    {
        $inventory = Inventory::with(['product', 'reviews.account', 'offers'])->findOrFail($inventoryId);
        return view('customer.product', compact('inventory'));
    }

    public function testimonials()
    {
        return view('customer.testimonials');
    }

    public function contact()
    {
        return view('customer.contact');
    }

    public function privacy()
    {
        return view('customer.privacy');
    }

    public function terms()
    {
        return view('customer.terms');
    }

    public function refunds()
    {
        return view('customer.refunds');
    }
}
