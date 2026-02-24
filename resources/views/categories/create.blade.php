@extends('layouts.pos')

@section('title', 'Create Category')

@section('content')


<div class="max-w-2xl mx-auto bg-black rounded shadow p-6 mt-6">
    <div class="flex justify-end">
     <a href="{{ route('categories.index') }}" 
        class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-green transition">
        View all Categorie
</a>
</div>
    <h2 class="text-2xl font-semibold mb-6 text-blue">Add New Category</h2>


    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block font-medium text-green-700 mb-1">Category Name</label>
            <input type="text" name="name" id="name" placeholder="Enter category name"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200 text-black"
                value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="description" class="block font-medium text-green-600 mb-1">Description (Optional)</label>
            <textarea  name="description" id="description" rows="3" placeholder="Add a short description"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200 text-black">{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('products.create') }}"
               class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 transition">
               Cancel
            </a>
            <button type="submit" 
                class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 transition">
                Create Category
            </button>
        </div>
    </form>
</div>
@endsection
