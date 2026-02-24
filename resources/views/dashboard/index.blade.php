@extends('layouts.pos')

@section('title', 'Dashboard')

@section('content')

<!-- Stat Cards Grid -->
<div class="flex flex-wrap gap-6 mb-8">
    <div class="flex-1 min-w-[400px]">
        <x-stat-card title="Total Products" :value="$total_products" icon="📦" />
    </div>
    <div class="flex-1 min-w-[400px]">
        <x-stat-card title="Sales Today" :value="$today_sales" icon="🛒" />
    </div>
    <div class="flex-1 min-w-[400px]">
        <x-stat-card title="Revenue Today" :value="'FCFA '.number_format($today_revenue, 2)" icon="💰" />
    </div>
    <div class="flex-1 min-w-[400px]">
        <x-stat-card title="Transactions" :value="$today_sales" icon="📄" />
    </div>
</div>

<!-- Recent Transactions Table -->
<div class="bg-white dark:bg-slate-800 
            rounded-xl shadow-xl p-6 
            transition-colors duration-300">

    <h2 class="font-semibold text-xl mb-4 
               text-blue dark:text-gray-200">
        Recent Transactions
    </h2>

    <div class="overflow-x-auto">
        <table class="w-full text-left table-auto border-collapse">

            <thead>
                <tr class="bg-green-100 dark:bg-slate-700">
                    <th class="px-4 py-3 font-medium text-gray-600 dark:text-white-300">Number</th>
                    <th class="px-4 py-3 font-medium text-gray-600 dark:text-white-300">Seller's Name</th>
                    <th class="px-4 py-3 font-medium text-gray-600 dark:text-white-300">Sales Date</th>
                    <th class="px-4 py-3 font-medium text-gray-600 dark:text-white-300">Total Amount</th>
                    <th class="px-4 py-3 font-medium text-gray-600 dark:text-white-300">Amount Paid</th>
                    <th class="px-4 py-3 font-medium text-gray-600 dark:text-white-300">Change Made</th>
                </tr>
            </thead>

            <tbody>
                @foreach($recent_sales as $sale)
                <tr class="border-b border-gray-200 dark:border-slate-600 
                           hover:bg-gray-50 dark:hover:bg-slate-700 
                           transition-colors">

                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                        {{ $loop->iteration }}
                    </td>

                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                        {{ $sale->user->name ?? 'N/A' }}
                    </td>

                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                        {{ optional($sale->sale_date)->format('d M Y') }}
                    </td>

                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                        {{ number_format($sale->total_amount, 2) }}
                    </td>

                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                        {{ number_format($sale->amount_paid, 2) }}
                    </td>

                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                        {{ number_format($sale->change_amount, 2) }}
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

@endsection
