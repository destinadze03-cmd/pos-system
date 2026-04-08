<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Message;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Purchase activity for graph (last 7 days)
        $purchases = Purchase::selectRaw('DATE(created_at) as date, SUM(quantity) as total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->take(10)
            ->get();

        $purchase_chart = [
            'labels' => $purchases->pluck('date'),
            'data' => $purchases->pluck('total')
        ];

        // NEW: Get recent messages
        $messages = Message::with('user')
            ->latest()
            ->take(5)
            ->get();

        $data = [
            'total_products' => Product::count(),
            'today_sales' => Sale::whereDate('sale_date', $today)->count(),
            'today_revenue' => Sale::whereDate('sale_date', $today)->sum('total_amount'),
            'recent_sales' => Sale::with(['user','saleItems.product'])
                ->latest()
                ->take(5)
                ->get(),
            'low_stock_products' => Product::where('stock_quantity','<=',5)->get(),

            'purchase_chart' => $purchase_chart,

            // ADD THIS
            'messages' => $messages
        ];

        return view('dashboard.index', $data);
    }
}