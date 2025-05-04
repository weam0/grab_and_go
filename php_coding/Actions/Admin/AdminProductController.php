<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Traits\UploadFile;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    use UploadFile;

    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product,name',
            'description' => 'nullable|string',
            'imageUrl' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoryId' => 'required|exists:category,categoryId',
        ]);

        $imagePath = $this->upload($request->file('imageUrl'));

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'imageUrl' => $imagePath,
            'categoryId' => $request->categoryId,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product,name,' . $product->productId . ',productId',
            'description' => 'nullable|string',
            'imageUrl' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoryId' => 'required|exists:category,categoryId',
        ]);
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'categoryId' => $request->categoryId,
        ];
        if ($request->hasFile('imageUrl')) {
            if (file_exists(public_path($product->imageUrl))) {
                unlink(public_path($product->imageUrl));
            }
            $data['imageUrl'] = $this->upload($request->file('imageUrl'));
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if (file_exists(public_path($product->imageUrl))) {
            unlink(public_path($product->imageUrl));
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
