@extends('layouts.pos')

@section('title', 'Sale Details')

@section('content')
<div class="">

    <h2 class="text-xl font-bold mb-4">
        Sale Number   {{ $sale->id }}
    </h2>

    <div class="mb-4 text-sm text-gray-600">
        <p><strong>Date:</strong> {{ $sale->sale_date }}</p>
        <p><strong>Cashier:</strong> {{ $sale->user->name ?? 'N/A' }}</p>
    </div>
    <div class="flex justify-end">
    <a href="{{ route('receipt.show', $sale->id) }}"
       class="bg-green-600 text-blue px-4 py-2 rounded hover:bg-green-700">
        🧾 Make Receipt
    </a>
</div>



    <table class="w-full border mb-4">
        <thead class="bg-green-100 text-left  text-black">
            <tr>
                <th class="p-2 border">Product</th>
                <th class="p-2 border">Qty</th>
                <th class="p-2 border">Unit Price</th>
                <th class="p-2 border">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
            <tr>
                <td class="p-2 border">
                    {{ $item->product->name ?? 'Deleted product' }}
                </td>
                <td class="p-2 border">{{ $item->quantity }}</td>
                <td class="p-2 border">
                    FCFA {{ number_format($item->unit_price, 2) }}
                </td>
                <td class="p-2 border">
                    FCFA {{ number_format($item->subtotal, 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-right space-y-1">
        <p><strong>Total:</strong> FCFA {{ number_format($sale->total_amount, 2) }}</p>
        <p><strong>Paid:</strong> FCFA {{ number_format($sale->amount_paid, 2) }}</p>
        <p><strong>Change:</strong> FCFA {{ number_format($sale->change_amount, 2) }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('pos.index') }}"
           class="inline-block bg-blue-600 text-blue px-4 py-2 rounded">
            New Sale
        </a>
    </div>


</div>
@endsection
