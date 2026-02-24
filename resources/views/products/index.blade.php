@extends('layouts.pos')

@section('title', 'Products')

@section('content')
<div class="flex justify-between mb-4 items-center">
    <h2 class="text-xl font-bold">Products</h2>
    <a href="{{ route('products.create') }}" class="bg-blue-600 text-blue px-4 py-2 rounded hover:bg-blue-700">
        Add Product
    </a>
</div>

<!-- Search Input -->
<input type="text" id="search" placeholder="Search product..." class="mb-4 w-full p-2 border rounded focus:outline-none focus:ring focus:ring-blue-200 text-black">

<!-- Products Table -->
<table id="productsTable" class="w-full bg-orange rounded shadow">
    <thead>
        <tr class="border-b text-left bg-green-100 text-black">
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Category</th>
            <th class="px-4 py-2">Price</th>
            <th class="px-4 py-2">Stock</th>
            <th class="px-4 py-2">Edit</th>
            <th class="px-4 py-2">Action</th>
            <th class="px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr class="border-b text-left">
            <td class="px-4 py-2">{{ $product->name }}</td>
            <td class="px-4 py-2">{{ $product->category->name ?? 'N/A' }}</td>
            <td class="px-4 py-2">FCFA {{ number_format($product->price, 2) }}</td>
            <td class="px-4 py-2">
    @if($product->stock_quantity > 0)
        {{ $product->stock_quantity }}
    @else
        <span class="text-red-600 font-bold">Out of Stock</span>
    @endif
</td>

            <td class="px-4 py-2">
                <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:underline">Edit</a>
            </td>

            <td class="px-4 py-2">
                <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:underline">view</a>
            </td>
            <td class="px-4 py-2">
                <form method="POST" action="{{ route('products.destroy', $product) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this product?')">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Live Search Script -->
<script>
    const searchInput = document.getElementById('search');
    const tableBody = document.getElementById('productsTable').getElementsByTagName('tbody')[0];

    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();
        const rows = tableBody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let match = false;
            // Only check first 4 columns (Name, Category, Price, Stock)
            for (let j = 0; j < 4; j++) {
                if (cells[j].innerText.toLowerCase().includes(filter)) {
                    match = true;
                    break;
                }
            }
            rows[i].style.display = match ? '' : 'none';
        }
    });
</script>
@endsection
