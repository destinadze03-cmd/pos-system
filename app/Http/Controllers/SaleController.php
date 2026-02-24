<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */



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

    $rangeTotal = 0;

    if ($request->filled('from') && $request->filled('to')) {
        $rangeTotal = Sale::whereBetween('created_at', [
            $request->from . ' 00:00:00',
            $request->to . ' 23:59:59'
        ])->sum('total_amount');
    }

    return view('sales.index', compact('sales', 'rangeTotal'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0',
            'products' => 'required|array',
        ]);

        $sale = Sale::create([
            'total' => collect($request->products)->sum(function($p) {
                return $p['price'] * $p['quantity'];
            }),
            'amount_paid' => $request->amount_paid,
            'user_id' => auth()->id(),
        ]);

        // Save products sold (many-to-many)
        foreach ($request->products as $id => $data) {
            $sale->products()->attach($id, [
                'quantity' => $data['quantity'],
                'price' => $data['price']
            ]);
        }

        return redirect()->route('sales.index')->with('success', 'Sale completed successfully.');
    }

    /**
     * Display the specified resource.
     */
    // SaleController.php
public function show(Sale $sale)
{
    return view('sales.show', compact('sale'));
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function receipt($sale)
{
    $sale = \App\Models\Sale::with('items.product')->findOrFail($sale);

    return view('receipt.show', compact('sale'));
}

public function print(Request $request)
{
    $sales = Sale::whereBetween('created_at', [
        $request->from . ' 00:00:00',
        $request->to . ' 23:59:59'
    ])->get();

    $rangeTotal = $sales->sum('total_amount');

    return view('Report.print', compact('sales', 'rangeTotal'));
}




public function exportPdf(Request $request)
{
    $query = Sale::with('products');

    if ($request->filled('from') && $request->filled('to')) {
        $query->whereBetween('created_at', [
            $request->from . ' 00:00:00',
            $request->to . ' 23:59:59'
        ]);
    }

    $sales = $query->latest()->get();

    $rangeTotal = $sales->sum('total_amount'); // make sure this matches your table column

    $pdf = Pdf::loadView('Report.print', compact('sales', 'rangeTotal'));

    return $pdf->download('sales-report.pdf');
}


}
