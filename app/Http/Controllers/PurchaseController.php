<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockMovement;

class PurchaseController extends Controller
{
    // Show all purchases
    public function index()
    {
        $purchases = Purchase::all();
        $categories = Category::all();

        return view('purchases.index', compact('purchases','categories'));
    }

    // Show form to create purchase
    public function create()
    {
        $categories = Category::all();
        return view('purchases.create', compact('categories'));
    }

    // Store new purchase
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'purchase_date' => 'required|date',
        ]);

        $purchase = Purchase::create($request->only([
            'product_name', 'quantity', 'price', 'supplier_name', 'purchase_date'
        ]));

        // Check if product exists
        $product = Product::firstOrCreate(
            ['name' => $request->product_name],
            [
                'category_id' => 2, // change if needed
                'price' => $request->price,
                'stock_quantity' => 0
            ]
        );

        // Increment stock
        $product->increment('stock_quantity', $request->quantity);
        $product->update(['price' => $request->price]);

        // Record stock movement
        StockMovement::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'type' => 'purchase',
            'reference_id' => $purchase->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase created and stock updated!');
    }

    // Show single purchase
    public function show(Purchase $purchase)
    {
        return view('purchases.show', compact('purchase'));
    }

    // Edit purchase form
    public function edit(Purchase $purchase)
    {
        $categories = Category::all();
        return view('purchases.edit', compact('purchase','categories'));
    }

    // Update purchase
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $oldQuantity = $purchase->quantity;
        $purchase->update($request->only(['product_name','quantity','price','supplier_name','purchase_date']));

        $product = Product::where('name', $purchase->product_name)->first();
        if ($product) {
            $diff = $request->quantity - $oldQuantity;
            $product->increment('stock_quantity', $diff);
            $product->update(['price' => $request->price]);

            StockMovement::create([
                'product_id' => $product->id,
                'quantity' => $diff,
                'type' => 'update',
                'reference_id' => $purchase->id,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase updated and stock adjusted!');
    }

    // Delete purchase
    public function destroy(Purchase $purchase)
    {
        $product = Product::where('name', $purchase->product_name)->first();
        if ($product) {
            $product->decrement('stock_quantity', $purchase->quantity);

            StockMovement::create([
                'product_id' => $product->id,
                'quantity' => -$purchase->quantity,
                'type' => 'delete',
                'reference_id' => $purchase->id,
                'user_id' => auth()->id(),
            ]);
        }

        $purchase->delete();

        return redirect()->route('purchases.index')
            ->with('success', 'Purchase deleted and stock adjusted!');
    }

    // Add stock to existing product
    public function addStock($id)
    {
        $purchase = Purchase::findOrFail($id);
        $product = Product::where('name', $purchase->product_name)->first();

        if ($product) {
            $product->increment('stock_quantity', $purchase->quantity);

            StockMovement::create([
                'product_id' => $product->id,
                'quantity' => $purchase->quantity,
                'type' => 'purchase',
                'reference_id' => $purchase->id,
                'user_id' => auth()->id()
            ]);
        }

        return redirect()->back()->with('success', 'Stock added and recorded.');
    }

    // Send purchase to product list
    public function sendToProducts($id)
    {
        $purchase = Purchase::findOrFail($id);

        $product = Product::firstOrCreate(
            ['name' => $purchase->product_name],
            [
                'category_id' => 2,
                'price' => $purchase->price,
                'stock_quantity' => 0
            ]
        );

        $product->increment('stock_quantity', $purchase->quantity);

        StockMovement::create([
            'product_id' => $product->id,
            'quantity' => $purchase->quantity,
            'type' => 'purchase',
            'reference_id' => $purchase->id,
            'user_id' => auth()->id()
        ]);

        return redirect()->back()
            ->with('success', 'Purchase item added to product list and recorded.');
    }
}