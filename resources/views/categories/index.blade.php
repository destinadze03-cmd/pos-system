@extends('layouts.pos')

@section('title', 'Categories')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- Page Title -->
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
        Categories List
    </h1>
<div class="flex justify-between mb-4 items-center">
   
    <a href="{{ route('categories.create') }}" class="bg-blue-600 text-blue px-4 py-2 rounded hover:bg-blue-700">
        Add Category
    </a>
</div>
    <!-- Table -->
    <div class="bg-white dark:bg-slate-800 shadow rounded-lg overflow-hidden">

        <table class="w-full text-left border-collapse">

            <thead class="bg-green-100 dark:bg-slate-700 text-black">
                <tr>
                    <th class="p-3">Number</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Description</th>
                    <th class="p-3">Created</th>
                    <th class="p-3">Action</th>
                  <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($categories as $category)
                    <tr class="border-t dark:border-slate-600 hover:bg-gray-300 dark:hover:bg-slate-700 transition">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3 font-medium">{{ $category->name }}</td>
                        <td class="p-3 font-medium">{{ $category->description }}</td>
                        <td class="p-3">{{ $category->created_at->format('d M Y') }}</td>
                        <td class="p-3"><button><a href="{{ route('categories.edit', $category->id) }}"
                         class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded">
                        Edit
                        </a></button>
                        </td>
    <td class="p-3">

         <form action="{{ route('categories.destroy', $category->id) }}" 
          method="POST"
          onsubmit="return confirm('Are you sure you want to delete this category?')">

        @csrf
        @method('DELETE')

        <button type="submit"
            class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded">
            Delete
        </button>

    </form>

</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">
                            No categories found
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
