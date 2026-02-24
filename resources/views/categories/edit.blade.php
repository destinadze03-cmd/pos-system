@extends('layouts.pos')

@section('title', 'Edit Category')

@section('content')

<div class="">

    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
        Edit Category
    </h1>

    <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow">

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Category Name -->
            <div class="mb-4">
                <label class="block mb-2 text-gray-700 dark:text-gray-300">
                    Category Name
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name', $category->name) }}"
                       class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600 dark:text-black text-black"
                       required>

                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

<div class="mb-4">
                <label class="block mb-2 text-gray-700 dark:text-gray-300">
                    Category Description
                </label>

                <input type="text"
                       name="description"
                       value="{{ old('description', $category->description) }}"
                       class="w-full p-2 border rounded dark:bg-slate-700 dark:border-slate-600 dark:text-black text-black "
                       required>

                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>


            <!-- Buttons -->
            <div class="flex justify-between">

                <a href="{{ route('categories.index') }}"
                   class="px-4 py-2 bg-gray-400 text-blue rounded hover:bg-gray-500">
                   Back
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Update Category
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
