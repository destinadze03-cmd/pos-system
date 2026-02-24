@extends('layouts.pos')

@section('title', 'Sales Report')

@section('content')

<div class="max-w-6xl mx-auto bg-black p-6 rounded shadow">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Sales Report</h2>

        <button onclick="window.print()" 
            class="bg-blue-600 text-blue px-4 py-2 rounded hover:bg-blue-700 print:hidden">
            Print
        </button>
    </div>

    @if(request('from') && request('to'))
        <div class="mb-4 text-blue">
            <strong>From:</strong> {{ request('from') }}
            <strong class="ml-4">To:</strong> {{ request('to') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 text-black">
            <thead class="bg-green-100">
                <tr>
                    <th class="border px-4 py-2 text-left">Number</th>
                    <th class="border px-4 py-2 text-left">Product</th>
                    <th class="border px-4 py-2 text-left">Quantity sold</th>
                    <th class="border px-4 py-2 text-left">Total</th>
                    <th class="border px-4 py-2 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    @foreach($sale->products as $product)
                    <tr class="hover:bg-gray-50 text-gray-500">
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $product->name }}</td>
                        <td class="border px-4 py-2">{{ $product->pivot->quantity }}</td>
                        <td class="border px-4 py-2">
                            FCFA {{ number_format($product->pivot->quantity * $product->pivot->unit_price, 2) }}
                        </td>
                        <td class="border px-4 py-2">{{ $sale->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 text-right text-lg font-bold text-green-700">
        Total: FCFA {{ number_format($rangeTotal, 2) }}
    </div>

</div>

@endsection
