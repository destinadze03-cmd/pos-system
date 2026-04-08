@extends('layouts.pos')

@section('title', 'Admin Dashboard')

@section('content')


@if(session('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4 border border-red-300">
        {{ session('error') }}
    </div>
@endif
<!-- Stat Cards Grid -->
<div class="flex flex-wrap gap-6 mb-8">

    <div class="flex-1 min-w-[400px]">
        <x-stat-card title="Total Products" :value="$total_products" icon="📦" />
    </div>

    <div class="flex-1 min-w-[400px]">
        <x-stat-card title="Sales Today" :value="$today_sales" icon="🛒" />
    </div>

    <div class="flex-1 min-w-[400px]">
        <x-stat-card title="Revenue Today" :value="'FCFA '.number_format($today_revenue,2)" icon="💰" />
    </div>

    <div class="flex-1 min-w-[400px]">
        <x-stat-card title="Transactions" :value="$today_sales" icon="📄" />
    </div>

</div>


<!-- Recent Transactions -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl p-6 mb-8">

    <h2 class="font-semibold text-xl mb-4 text-blue dark:text-gray-200">
        Recent Transactions
    </h2>

    <div class="overflow-x-auto">

        <table class="w-full text-left table-auto border-collapse">

            <thead>
                <tr class="bg-green-100 dark:bg-slate-700">

                    <th class="px-4 py-3">Number</th>
                    <th class="px-4 py-3">Seller</th>
                    <th class="px-4 py-3">Product Name</th>
                    <th class="px-4 py-3">Sales Date</th>
                    <th class="px-4 py-3">Total Amount</th>
                    <th class="px-4 py-3">Amount Paid</th>
                    <th class="px-4 py-3">Change</th>

                </tr>
            </thead>

            <tbody>

                @foreach($recent_sales as $sale)

                <tr class="border-b hover:bg-gray-50 dark:hover:bg-slate-700">

                    <td class="px-4 py-3">
                        {{ $loop->iteration }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $sale->user->name ?? 'N/A' }}
                    </td>


                    <td class="px-4 py-3">
    @if($sale->items->count())
        @foreach($sale->items as $item)
            {{ $item->product->name }}@if(!$loop->last), @endif
        @endforeach
    @else
        N/A
    @endif
</td>

                    <td class="px-4 py-3">
                        {{ optional($sale->sale_date)->format('d M Y') }}
                    </td>

                    <td class="px-4 py-3">
                        {{ number_format($sale->total_amount,2) }}
                    </td>

                    <td class="px-4 py-3">
                        {{ number_format($sale->amount_paid,2) }}
                    </td>

                    <td class="px-4 py-3">
                        {{ number_format($sale->change_amount,2) }}
                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>


<!-- Graph + Messages -->
<div class="grid md:grid-cols-2 gap-6">

<!-- Purchase Activity Graph -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl p-6">

    <h2 class="font-semibold text-xl mb-4 text-gray-700 dark:text-gray-200">
        Purchase Activity
    </h2>

    <canvas id="purchaseChart"></canvas>

</div>



<!-- Recent Messages -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl p-6">

<h2 class="font-semibold text-xl mb-4 text-gray-700 dark:text-gray-200">
Recent Messages
</h2>

<!-- Send Message -->
@foreach($messages as $msg)

<div class="p-4 bg-gray-100 dark:bg-slate-700 rounded-lg">

<strong>{{ $msg->user->name }}</strong>: {{ $msg->message }}

<!-- Replies -->
@if($msg->replies->count())
<div class="ml-6 mt-2 space-y-2">
@foreach($msg->replies as $reply)
<div class="p-2 bg-gray-200 dark:bg-slate-600 rounded">
<strong>{{ $reply->user->name }}</strong>: {{ $reply->message }}
</div>
@endforeach
</div>
@endif

<!-- Reply form -->
<form action="{{ route('messages.store') }}" method="POST" class="flex gap-2 mt-3">
@csrf

<input type="hidden" name="parent_id" value="{{ $msg->id }}">

<input type="text"
       name="message"
       placeholder="Reply..."
       class="flex-1 border rounded px-3 py-1 text-black"
       required>

<button class="bg-green-600 text-white px-3 py-1 rounded">
Reply
</button>

</form>

</div>

@endforeach

</div>

</div>

</div>



<!-- Chart Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const purchaseData = @json($purchase_chart);

const ctx = document.getElementById('purchaseChart');

new Chart(ctx, {

    type: 'bar',

    data: {
        labels: purchaseData.labels,
        datasets: [{
            label: 'Purchases',
            data: purchaseData.data,
            borderWidth: 1
        }]
    },

    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }

});

</script>

@endsection