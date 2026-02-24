<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class POSController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pos.index', compact('products'));
    }

  

public function checkout(Request $request)
{
    $request->validate([
        'amount_paid' => 'required|numeric|min:0',
        'products' => 'required|array'
    ]);

    DB::beginTransaction();

    try {

        // 1️⃣ Calculate total
        $total = 0;
        foreach ($request->products as $productId => $item) {
            $total += $item['quantity'] * $item['price'];
        }

        // 2️⃣ Create sale
        $sale = Sale::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'amount_paid' => $request->amount_paid,
            'change_amount' => $request->amount_paid - $total,
            'sale_date' => now(),
        ]);

        // 3️⃣ Create sale items + reduce stock
        foreach ($request->products as $productId => $item) {

            $product = Product::findOrFail($productId);

            // 🚨 Check stock first
            if ($product->stock_quantity < $item['quantity']) {
                throw new \Exception("Not enough stock for {$product->name}");
            }

            // Save sale item
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['quantity'] * $item['price'],
            ]);

            // 🔥 Reduce stock
            $product->decrement('stock_quantity', $item['quantity']);
        }

        DB::commit();

        return redirect()
            ->route('sales.show', $sale->id)
            ->with('success', 'Sale completed successfully');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());
    }
}


public function getProductByBarcode($barcode)
{
    $product = \App\Models\Product::where('barcode', $barcode)->first();

    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    return response()->json($product);
}

}