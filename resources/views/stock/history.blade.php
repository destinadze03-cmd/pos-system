{{-- resources/views/stock/history.blade.php --}}
@extends('layouts.pos')

@section('title', 'Stock History')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-black dark:bg-slate-800 rounded shadow">
    <h2 class="text-xl font-semibold text-gray-100 mb-4">Inventory Audit Dashboard</h2>

    {{-- Filters --}}
    <form method="GET" class="mb-4 flex gap-2 flex-wrap items-end">
        <div>
            <label class="block text-gray-200 text-sm">Product</label>
            <select name="product_id" class="px-3 py-2 border rounded text-black">
                <option value="">All Products</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-200 text-sm">Action Type</label>
            <select name="type" class="px-3 py-2 border rounded text-black">
                <option value="">All Types</option>
                <option value="purchase" {{ request('type')=='purchase' ? 'selected' : '' }}>Purchase</option>
                <option value="sale" {{ request('type')=='sale' ? 'selected' : '' }}>Sale</option>
                <option value="update" {{ request('type')=='update' ? 'selected' : '' }}>Update</option>
                <option value="delete" {{ request('type')=='delete' ? 'selected' : '' }}>Delete</option>
                <option value="adjustment" {{ request('type')=='adjustment' ? 'selected' : '' }}>Adjustment</option>
                <option value="adjustment" {{ request('type')=='' ? 'selected' : '' }}>Adjustment</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-200 text-sm">From</label>
            <input type="date" name="from" value="{{ request('from') }}" class="px-3 py-2 border rounded text-black">
        </div>

        <div>
            <label class="block text-gray-200 text-sm">To</label>
            <input type="date" name="to" value="{{ request('to') }}" class="px-3 py-2 border rounded text-black">
        </div>

        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Filter</button>
    </form>

    {{-- Stock Table --}}
    <table class="min-w-full table-auto border border-gray-200 dark:border-slate-700 rounded text-white">
        <thead>
            <tr class="bg-gray-100 dark:bg-slate-700 text-black bg-blue">
                <th class="px-4 py-2 border-b">Number</th>
                <th class="px-4 py-2 border-b">Product name</th>
                <th class="px-4 py-2 border-b">Type</th>
                <th class="px-4 py-2 border-b">Quantity</th>
                <th class="px-4 py-2 border-b">Reference ID</th>
                <th class="px-4 py-2 border-b">User</th>
                <th class="px-4 py-2 border-b">Date</th>
            </tr>
        </thead>
        <tbody>
    @forelse($movements as $movement)
    <tr class="hover:bg-gray-100 dark:hover:bg-slate-700 text-black">
    <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>

    {{-- Product / Entity Name --}}
    <td class="px-4 py-2 border-b">
        @if(str_contains(strtolower($movement->type), 'sale'))
            {{ $movement->movable->product->name ?? 'Sale Item' }}
        @elseif($movement->type == 'product')
            {{ $movement->movable->name ?? '-' }}
        @elseif($movement->type == 'category')
            {{ $movement->movable->name ?? '-' }}
        @else
            {{ $movement->product->name ?? '-' }}
        @endif
    </td>

    {{-- Action / Type --}}
    <td class="px-4 py-2 border-b">
        @if(str_contains(strtolower($movement->type), 'sale'))
            <span class="text-yellow-400">Sold</span>
        @elseif($movement->type == 'purchase')
            <span class="text-green-400">Purchased</span>
        @elseif($movement->type == 'delete')
            <span class="text-red-400">Deleted</span>
        @elseif($movement->type == 'update')
            <span class="text-blue-400">Updated</span>
        @else
            <span class="text-gray-400">{{ ucfirst($movement->type) }}</span>
        @endif
    </td>

    {{-- Quantity --}}
    <td class="px-4 py-2 border-b {{ $movement->quantity < 0 ? 'text-red-400' : 'text-green-400' }}">
        {{ $movement->quantity > 0 ? '+' : '' }}{{ $movement->quantity }}
    </td>

    {{-- Reference ID --}}
    <td class="px-4 py-2 border-b">{{ $movement->reference_id ?? '-' }}</td>

    {{-- User --}}
    <td class="px-4 py-2 border-b">{{ $movement->user->name ?? 'System' }}</td>

    {{-- Date --}}
    <td class="px-4 py-2 border-b text-sm">{{ $movement->created_at->format('d M Y H:i') }}</td>
</tr>
    @empty
    <tr>
        <td colspan="7" class="text-center py-4 text-gray-500">No logs found for the selected filters.</td>
    </tr>
    @endforelse
</tbody>

    </table>
</div>
@endsection