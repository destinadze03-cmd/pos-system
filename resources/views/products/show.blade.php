@extends('layouts.pos')

@section('title', 'Product Details')

@section('content')

<div class="">

    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
     

        <a href="{{ route('products.index') }}"
           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            Back
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Product Image -->
        <div>
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}"
                     class="w-full h-72 object-cover rounded-lg shadow">
            @else
                <div class="w-full h-72 bg-gray-200 flex items-center justify-center rounded-lg">
                    No Image
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="space-y-4">

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Product Name</p>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white">
                    {{ $product->name }}
                </h3>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Price</p>
                <p class="text-lg font-bold text-green-600">
                    {{ number_format($product->price, 2) }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Stock</p>
                <p class="text-lg text-gray-800 dark:text-white">
                    {{ $product->stock_quantity }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Category</p>
                <p class="text-lg text-gray-800 dark:text-white">
                    {{ $product->category->name ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">Description</p>
                <p class="text-gray-700 dark:text-gray-300">
                    {{ $product->description ?? 'No description available' }}
                </p>
            </div>

        </div>
    </div>

</div>

@endsection