<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\StockMovement;

class SaleController extends Controller
{
    // List all sales with optional date filter
    public function index(Request $request)
    {
        $query = Sale::with('products');

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59'
            ]);
        }

        $sales = $query->latest()->get();
        $rangeTotal = $sales->sum('total');

        return view('sales.index', compact('sales', 'rangeTotal'));
    }

    // Create sale form (optional)
    public function create() { }

    // Store a new sale
    public function store(Request $request)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0',
            'products' => 'required|array',
        ]);

        $sale = Sale::create([
            'total' => collect($request->products)->sum(fn($p) => $p['price'] * $p['quantity']),
            'amount_paid' => $request->amount_paid,
            'user_id' => auth()->id(),
        ]);

        foreach ($request->products as $id => $data) {
            $product = Product::findOrFail($id);
            $quantitySold = $data['quantity'];

            // Attach product to sale
            $sale->products()->attach($id, [
                'quantity' => $quantitySold,
                'price' => $data['price']
            ]);

            // Decrement stock
            $product->decrement('stock_quantity', $quantitySold);

            // Record stock movement
            StockMovement::create([
                'product_id' => $product->id,
                'quantity' => -$quantitySold, // negative because stock decreased
                'type' => 'sale',
                'reference_id' => $sale->id,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('sales.index')->with('success', 'Sale completed and stock updated.');
    }

    // Show sale details
    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    // Update a sale
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0',
            'products' => 'required|array',
        ]);

        $sale->update([
            'total' => collect($request->products)->sum(fn($p) => $p['price'] * $p['quantity']),
            'amount_paid' => $request->amount_paid,
        ]);

        foreach ($request->products as $id => $data) {
            $product = Product::findOrFail($id);
            $pivot = $sale->products()->where('product_id', $id)->first();
            $oldQuantity = $pivot ? $pivot->pivot->quantity : 0;
            $newQuantity = $data['quantity'];
            $diff = $newQuantity - $oldQuantity;

            // Update pivot table
            $sale->products()->syncWithoutDetaching([$id => ['quantity' => $newQuantity, 'price' => $data['price']]]);

            if ($diff != 0) {
                // Adjust stock
                $product->decrement('stock_quantity', $diff);

                // Record stock movement
                StockMovement::create([
                    'product_id' => $product->id,
                    'quantity' => -$diff,
                    'type' => 'update',
                    'reference_id' => $sale->id,
                    'user_id' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('sales.index')->with('success', 'Sale updated and stock adjusted.');
    }

    // Delete a sale
    public function destroy(Sale $sale)
    {
        foreach ($sale->products as $product) {
            $quantity = $product->pivot->quantity;

            // Restore stock
            $product->increment('stock_quantity', $quantity);

            // Record stock movement
            StockMovement::create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'type' => 'delete',
                'reference_id' => $sale->id,
                'user_id' => auth()->id(),
            ]);
        }

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale deleted and stock restored.');
    }

    // Sale receipt
    public function receipt($sale)
    {
        $sale = Sale::with('products')->findOrFail($sale);
        return view('receipt.show', compact('sale'));
    }
}