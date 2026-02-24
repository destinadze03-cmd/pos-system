<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $data = [
            'total_products' => Product::count(),
            'today_sales' => Sale::whereDate('sale_date', $today)->count(),
            'today_revenue' => Sale::whereDate('sale_date', $today)->sum('total_amount'),
            'recent_sales' => Sale::with(['user', 'saleItems.product'])
                                ->latest()
                                ->take(5)
                                ->get(),
            'low_stock_products' => Product::where('stock_quantity', '<=', 5)->get()
        ];

        return view('dashboard.index', $data);
    }
}
