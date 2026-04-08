@extends('layouts.pos')

@section('title', 'Purchases')

@section('content')

<div class="flex gap-6">

    <!-- LEFT SIDE : CREATE PURCHASE -->
    <div class="w-1/3 bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6">

        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
            Add New Purchase
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
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
                <input type="text" name="product_name"
                    value="{{ old('product_name') }}"
                    class="w-full px-3 py-2 border rounded text-black">
            </div>

            <div>
                <label class="block mb-1">Category</label>
                <select name="category_id" class="w-full px-3 py-2 border rounded text-black">
                    <option value="">Select Category</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="block mb-1">Quantity</label>
                <input type="number" name="quantity"
                    value="{{ old('quantity') }}"
                    class="w-full px-3 py-2 border rounded text-black">
            </div>

            <div>
                <label class="block mb-1">Price</label>
                <input type="number" step="0.01"
                    name="price"
                    value="{{ old('price') }}"
                    class="w-full px-3 py-2 border rounded text-black">
            </div>

            <div>
                <label class="block mb-1">Supplier</label>
                <input type="text"
                    name="supplier_name"
                    value="{{ old('supplier_name') }}"
                    class="w-full px-3 py-2 border rounded text-black">
            </div>

            <div>
                <label class="block mb-1">Purchase Date</label>
                <input type="date"
                    name="purchase_date"
                    value="{{ old('purchase_date', now()->format('Y-m-d')) }}"
                    class="w-full px-3 py-2 border rounded text-black">
            </div>

            <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                Save Purchase
            </button>

        </form>

    </div>


    <!-- RIGHT SIDE : PURCHASE LIST -->
    <div class="w-2/3 bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6">

        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
            All Purchases
        </h2>

        <div class="overflow-x-auto">

            <table class="w-full border">

                <thead class="bg-green-100 text-black">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Product</th>
                        <th class="px-4 py-2 border">Quantity</th>
                        <th class="px-4 py-2 border">Price</th>
                        <th class="px-4 py-2 border">Supplier</th>
                        <th class="px-4 py-2 border">Date</th>
                        <th class="px-4 py-2 border">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($purchases as $purchase)

                    <tr class="hover:bg-gray-50">

                        <td class="px-4 py-2 border">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-2 border">
                            {{ $purchase->product_name }}
                        </td>

                        <td class="px-4 py-2 border">
                            {{ $purchase->quantity }}
                        </td>

                        <td class="px-4 py-2 border">
                            FCFA {{ number_format($purchase->price,2) }}
                        </td>

                        <td class="px-4 py-2 border">
                            {{ $purchase->supplier_name }}
                        </td>

                        <td class="px-4 py-2 border">
                            {{ $purchase->purchase_date }}
                        </td>

                        <td class="px-4 py-2 border flex gap-2">

                            <form action="{{ route('purchases.addStock',$purchase->id) }}" method="POST">
                                @csrf
                                <button class="px-2 py-1 bg-green-600 text-white rounded">
                                    Add To Stock
                                </button>
                            </form>

                            <a href="{{ route('purchases.edit',$purchase->id) }}"
                                class="px-2 py-1 bg-blue-600 text-white rounded">
                                Edit
                            </a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection