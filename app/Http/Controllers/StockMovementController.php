<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockMovement;
use App\Models\Product;
use App\Models\User;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $query = StockMovement::with(['product', 'user']);

        // Optional: filter by product or date
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59',
            ]);
        }

        $movements = $query->latest()->get();
        $products = Product::all();

        return view('stock.history', compact('movements', 'products'));
    }
}