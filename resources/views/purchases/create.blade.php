@extends('layouts.pos')

@section('title', 'Add Purchase')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white dark:bg-slate-800 rounded shadow">

    <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Add New Purchase</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchases.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1">Product Name</label>
            <input type="text" name="product_name" value="{{ old('product_name') }}" class="w-full px-3 py-2 border rounded">
        </div>

<div>
    <label class="block mb-1">Category</label>
    <select name="category_id" class="w-full px-3 py-2 border rounded">
        <option value="">Select Category</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>


        <div>
            <label class="block mb-1">Quantity</label>
            <input type="number" name="quantity" value="{{ old('quantity') }}" class="w-full px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block mb-1">Price</label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block mb-1">Supplier (Optional)</label>
            <input type="text" name="supplier_name" value="{{ old('supplier_name') }}" class="w-full px-3 py-2 border rounded">
        </div>

        <div>
            <label class="block mb-1">Purchase Date</label>
            <input type="date" name="purchase_date" value="{{ old('purchase_date', now()->format('Y-m-d')) }}" class="w-full px-3 py-2 border rounded">
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('purchases.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Back</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save Purchase</button>
        </div>
    </form>
</div>
@endsection