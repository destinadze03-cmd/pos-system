<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\SaleItem;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all(); // Fetch all products
     $categories = Category::all(); 
        return view('products.index', compact('products','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:products,name',
        'category_id' => 'required|exists:categories,id',
        'barcode' => 'nullable|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ], [
        'name.unique' => 'Product already exists.'
    ]);

    Product::create([
        'name' => $request->name,
        'category_id' => $request->category_id,
        'barcode' => $request->barcode,
        'price' => $request->price,
        'stock_quantity' => $request->stock_quantity,
        'image' => $request->image
    ]);

    return redirect()->route('products.index')
                     ->with('success', 'Product created successfully.');
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            //'price' => 'required|numeric|min:0',
            //'stock_quantity' => 'required|integer|min:0',
            'barcode' => 'nullable|string|unique:products,barcode,' . $product->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only('name', 'category_id', 'price', 'stock_quantity', 'barcode', 'description');

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */


public function destroy(Product $product)
{
    // Check if product has been sold
    $hasSales = SaleItem::where('product_id', $product->id)->exists();

    if ($hasSales) {
        return redirect()->route('products.index')
            ->with('error', 'This product has been sold and cannot be deleted.');
    }

    $product->delete();

    return redirect()->route('products.index')
        ->with('success', 'Product deleted successfully.');
}

    public function show(Product $product)
{
    return view('products.show', compact('product'));
}





}


