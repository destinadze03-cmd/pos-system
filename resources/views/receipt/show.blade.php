@extends('layouts.pos')

@section('title', 'Receipt')

@section('content')
<div class="max-w-md mx-auto bg-white text-black p-6 rounded shadow text-sm" id="receipt">

    <!-- POS System Name -->
    <div class="text-center mb-3">
        <h1 class="text-lg font-bold">SMART POS SYSTEM</h1>
        <p>Buea, Cameroon</p>
        <p>Tel: +237 672 777 727</p>
    </div>

    <hr class="border-dashed border-gray-400 my-2">

    <!-- Receipt Info -->
    <div class="mb-2">
        <p><strong>Receipt No:</strong> {{ $sale->id }}</p>
        <p><strong>Date:</strong> {{ $sale->created_at->format('d M Y') }}</p>
        <p><strong>Time:</strong> {{ $sale->created_at->format('H:i A') }}</p>
        <p><strong>Cashier:</strong> {{ $sale->user->name ?? 'Admin' }}</p>
    </div>

    <hr class="border-dashed border-gray-400 my-2">

    <!-- Products -->
    <div>
        <div class="flex justify-between font-bold">
            <span>Item</span>
            <span>Total</span>
        </div>

        @foreach($sale->items as $item)
        <div class="mt-1">
            <div class="flex justify-between">
                <span>{{ $item->product->name }}</span>
                <span>FCFA {{ number_format($item->subtotal, 0) }}</span>
            </div>
            <div class="flex justify-between text-xs text-gray-600">
                <span>{{ $item->quantity }} x {{ number_format($item->price, 0) }}</span>
                <span></span>
            </div>
        </div>
        @endforeach
    </div>

    <hr class="border-dashed border-gray-400 my-2">

    <!-- Totals -->
    <div class="space-y-1">
        <div class="flex justify-between">
            <span>Subtotal:</span>
            <span>FCFA {{ number_format($sale->total_amount, 0) }}</span>
        </div>

        <div class="flex justify-between">
            <span>Amount Paid:</span>
            <span>FCFA {{ number_format($sale->amount_paid, 0) }}</span>
        </div> <div class="flex justify-between">
            <span>paymen method:</span>
            <span>{{ $sale->payment_method }}</span>
        </div>



        <div class="flex justify-between font-bold text-lg">
            <span>Balance:</span>
            <span>FCFA {{ number_format($sale->change_amount, 0) }}</span>
        </div>
    </div>

    <hr class="border-dashed border-gray-400 my-3">

    <!-- Extra Information -->
    <div class="text-xs space-y-1">
        <p><strong>Payment Method:</strong> Cash</p>
        <p><strong>Total Items:</strong> {{ $sale->items->sum('quantity') }}</p>
        <p>Goods sold are not returnable.</p>
    </div>

    <hr class="border-dashed border-gray-400 my-3">

    <!-- Footer -->
    <div class="text-center text-xs">
        <p>Thank you for shopping with us!</p>
        <p>Powered by SMART POS</p>
    </div>

    <!-- Print Button -->
    <button onclick="printReceipt()"
            class="mt-4 w-full bg-blue-600 text-white py-2 rounded print:hidden">
        Print Receipt
    </button>

</div>

<!-- Print Script -->
<script>
function printReceipt() {
    window.print();
}
</script>

<!-- Print Styling -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #receipt, #receipt * {
        visibility: visible;
    }
    #receipt {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>
@endsection