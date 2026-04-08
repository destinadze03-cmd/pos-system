@extends('layouts.pos')

@section('title', 'Stock Movement History')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-black dark:bg-slate-800 rounded shadow">
    <h2 class="text-xl font-semibold text-gray-100 mb-4">Inventory History</h2>

    <form method="GET" class="mb-4 flex gap-2">
        <select name="product_id" class="px-3 py-2 border rounded text-black">
            <option value="">All Products</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>

        <input type="date" name="from" value="{{ request('from') }}" class="px-3 py-2 border rounded">
        <input type="date" name="to" value="{{ request('to') }}" class="px-3 py-2 border rounded">
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Filter</button>
    </form>

    <table class="min-w-full table-auto border border-gray-200 dark:border-slate-700 rounded text-white">
        <thead>
            <tr class="bg-gray-100 dark:bg-slate-700 text-black">
                <th class="px-4 py-2 border-b">#</th>
                <th class="px-4 py-2 border-b">Product</th>
                <th class="px-4 py-2 border-b">Type</th>
                <th class="px-4 py-2 border-b">Quantity</th>
                <th class="px-4 py-2 border-b">Reference ID</th>
                <th class="px-4 py-2 border-b">User</th>
                <th class="px-4 py-2 border-b">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($movements as $movement)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                    <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border-b">{{ $movement->product->name ?? '-' }}</td>
                    <td class="px-4 py-2 border-b">{{ ucfirst($movement->type) }}</td>
                    <td class="px-4 py-2 border-b">{{ $movement->quantity }}</td>
                    <td class="px-4 py-2 border-b">{{ $movement->reference_id ?? '-' }}</td>
                    <td class="px-4 py-2 border-b">{{ $movement->user->name ?? 'System' }}</td>
                    <td class="px-4 py-2 border-b">{{ $movement->created_at->format('d M Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">No stock movements found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection