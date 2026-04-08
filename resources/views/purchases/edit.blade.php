@extends('layouts.pos')

@section('title', 'Edit Purchase')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white dark:bg-slate-800 rounded shadow">

    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Edit Purchase</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1">Product Name</label>
            <input type="text" name="product_name" value="{{ old('product_name', $purchase->product_name) }}" class="w-full px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block mb-1">Quantity</label>
            <input type="number" name="quantity" value="{{ old('quantity', $purchase->quantity) }}" class="w-full px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block mb-1">Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $purchase->price) }}" class="w-full px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block mb-1">Supplier (Optional)</label>
            <input type="text" name="supplier_name" value="{{ old('supplier_name', $purchase->supplier_name) }}" class="w-full px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block mb-1">Purchase Date</label>
            <input type="date" name="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date->format('Y-m-d')) }}" class="w-full px-3 py-2 border rounded">
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('purchases.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Back</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Purchase</button>
        </div>
    </form>
</div>
@endsection