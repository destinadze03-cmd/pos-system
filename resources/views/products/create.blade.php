@extends('layouts.pos')

@section('title', 'Create Product')

@section('content')
<!--<div class="max-w-3xl mx-auto bg-gray p-6 rounded shadow">-->
    <div class="">
    <h1 class="text-2xl font-bold mb-6">Add New Product</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Add enctype="multipart/form-data" for file uploads -->
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Product Name -->
        <div class="mb-4">
            <label for="name" class="block font-medium mb-1">Product Name</label>
            <input type="text" name="name" id="name" class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 text-black" value="{{ old('name') }}" required>
        </div>

        <!-- Category Selection -->
       <div class="mb-4">
            <label for="category_id" class="block font-medium mb-1">Category</label>
            <div class="flex gap-2 items-center">
                <select name="category_id" id="category_id" class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 text-black" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Add Category Button -->
                <a href="{{ route('categories.create') }}" class="bg-green-600 text-blue px-3 py-2 rounded hover:bg-green-700 transition text-sm text-black">
                    + Add
                </a>
            </div>
        </div>

        <!-- Barcode -->
        <div class="mb-4">
            <label for="barcode" class="block font-medium mb-1">Barcode</label>
            <input type="text" name="barcode" id="barcode" class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 text-black" value="{{ old('barcode') }}">
        </div>

        <!-- Price -->
        <div class="mb-4">
            <label for="price" class="block font-medium mb-1">Price</label>
            <input type="number" name="price" id="price" step="0.01" class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 text-black" value="{{ old('price') }}" required>
        </div>

        <!-- Stock Quantity -->
        <div class="mb-4">
            <label for="stock_quantity" class="block font-medium mb-1">Stock Quantity</label>
            <input type="number" name="stock_quantity" id="stock_quantity" class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 text-black" value="{{ old('stock_quantity') }}" required>
        </div>

        <!-- Product Image Upload -->
        <div class="mb-4">
            <label for="image" class="block font-medium mb-1">Product Image</label>
            <input type="file" name="image" id="image" accept="image/*" class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200text-black">

            <!-- Image Preview -->
            <div class="mt-2">
                <img id="image-preview" src="#" alt="Image Preview" class="hidden w-32 h-32 object-contain border rounded">
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-blue-600 text-blue px-6 py-2 rounded hover:bg-blue-700 transition">
            Save Product
        </button>
    </form>
</div>

<!-- JS for Image Preview -->
<script>
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            reader.addEventListener('load', function() {
                imagePreview.setAttribute('src', this.result);
                imagePreview.classList.remove('hidden');
            });

            reader.readAsDataURL(file);
        } else {
            imagePreview.setAttribute('src', '#');
            imagePreview.classList.add('hidden');
        }
    });
</script>
@endsection
