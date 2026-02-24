@extends('layouts.pos')

@section('title', 'Receipt')

@section('content')
<div class="max-w-md mx-auto bg-black p-6 rounded shadow">
    <h2 class="text-center text-xl font-bold mb-4">POS SYSTEM RECEIPT</h2>

    @foreach($sale->items as $item)
    <div class="flex justify-between">
        <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
        <span>FCFA          {{ $item->subtotal }}</span>
    </div>
    @endforeach

    <hr class="my-3">

    <p>Total: <strong>FCFA   {{ $sale->total_amount }}</strong></p>
    <p>Paid: FCFA       {{ $sale->amount_paid }}</p>
    <p>Change: FCFA            {{$sale->change_amount }}</p>

    <button onclick="window.print()"
            class="mt-4 w-full bg-blue-600 text-blue py-2 rounded">
        Print Receipt
    </button>
</div>
@endsection
