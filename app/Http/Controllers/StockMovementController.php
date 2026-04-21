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
    $query = StockMovement::with(['product', 'user', 'movable']);

    // Filter by product
    if ($request->filled('product_id')) {
        $query->where('product_id', $request->product_id);
    }

    // Filter by type (IMPORTANT)
    if ($request->filled('type')) {

        if ($request->type === 'sale') {
            $query->where('type', \App\Models\Sale::class);
        }

        if ($request->type === 'purchase') {
            $query->where('type', \App\Models\Purchase::class);
        }

        if ($request->type === 'update') {
            $query->where('action', 'updated');
        }

        if ($request->type === 'delete') {
            $query->where('action', 'deleted');
        }

        if ($request->type === 'adjustment') {
            $query->where('action', 'adjustment');
        }
    }

    $movements = $query->latest()->get();
    $products = Product::all();

    return view('activity.log', compact('movements', 'products'));
}
}