@extends('layouts.pos')

@section('title', 'Edit Product')

@section('content')
<!--<div class="max-w-3xl mx-auto bg-black p-6 rounded shadow">-->
    <div >
    <h1 class="text-2xl font-bold mb-6">Edit Product</h1>

    {{-- Display validation errors --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- IMPORTANT: enctype added --}}
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Product Name --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Product Name</label>
            <input type="text" name="name"
                   class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 text-black"
                   value="{{ old('name', $product->name) }}" required>
        </div>

        {{-- Category --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Category</label>

            <div class="flex gap-2 items-center">
                <select name="category_id"
                        class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 text-black"
                        required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <a href="{{ route('categories.create') }}"
                   class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm">
                    + Add
                </a>
            </div>
        </div>

        {{-- Barcode --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Barcode</label>
            <input type="text" name="barcode"
                   class="w-full border p-2 rounded text-black"
                   value="{{ old('barcode', $product->barcode) }}">
        </div>

        {{-- Price --}}
        <div class="mb-4">
    <label class="block font-medium mb-1">Price</label>
    <p class="bg-gray-200 p-2 rounded text-black">
        {{ number_format($product->price, 2) }}
    </p>
</div>

        {{-- Stock Quantity --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Stock Quantity</label>
            <input type="number"
       class="w-full bg-gray-200 border-gray-300 rounded px-3 py-2 text-black cursor-not-allowed"
       value="{{ $product->stock_quantity }}" readonly>
        </div>

        {{-- Current Image --}}
        @if($product->image)
            <div class="mb-4">
                <label class="block font-medium mb-1">Current Image</label>
                <img src="{{ asset('storage/' . $product->image) }}"
                     class="w-32 h-32 object-contain border rounded">
            </div>
        @endif

        {{-- Upload New Image --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Change Product Image</label>
            <input type="file" name="image" id="image"
                   accept="image/*"
                   class="w-full border-gray-300 rounded px-3 py-2">
            
            <div class="mt-2">
                <img id="image-preview"
                     class="hidden w-32 h-32 object-contain border rounded">
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="bg-blue-600 text-blue px-4 py-2 rounded hover:bg-blue-700">
                Update Product
            </button>
        </div>
    </form>
</div>

{{-- Image Preview Script --}}
<script>
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('image-preview');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
