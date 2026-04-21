@extends('layouts.pos')

@section('title', 'Products')

@section('content')

@if(session('error'))
<script>
    alert("{{ session('error') }}");
</script>
@endif


<div class="max-w-7xl mx-auto p-6">

    <!-- PAGE HEADER --
    <div class="flex justify-between mb-6 items-center">
        <h2 class="text-2xl font-bold">Products Management</h2>
        <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Add Product Page
        </a>
    </div>-->


    <!-- ADD PRODUCT CARD -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 mb-8">

        <h3 class="text-xl font-bold mb-6">Add New Product</h3>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- Product Name -->
                <div>
                    <label class="block font-medium mb-1">Product Name</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2 text-black" required>
                </div>

                <!-- Category -->
                <div>
                    <label class="block font-medium mb-1">Category</label>
                    <div class="flex gap-2">
                        <select name="category_id" class="w-full border rounded px-3 py-2 text-black" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                        <a href="{{ route('categories.create') }}"
                           class="bg-green-600 text-white px-3 py-2 rounded hover:bg-green-700 text-sm">
                           + Add
                        </a>
                    </div>
                </div>

                <!-- Barcode -->
                <div>
                    <label class="block font-medium mb-1">Barcode</label>
                    <input type="text" name="barcode" class="w-full border rounded px-3 py-2 text-black">
                </div>

                <!-- Price -->
                <div>
                    <label class="block font-medium mb-1">Price</label>
                    <input type="number" name="price" step="0.01"
                        class="w-full border rounded px-3 py-2 text-black" required>
                </div>

                <!-- Stock -->
                <div>
                    <label class="block font-medium mb-1">Stock Quantity</label>
                    <input type="number" name="stock_quantity"
                        class="w-full border rounded px-3 py-2 text-black" required>
                </div>

                <!-- Image -->
                <div>
                    <label class="block font-medium mb-1">Product Image</label>
                    <input type="file" name="image" id="image"
                        class="w-full border rounded px-3 py-2 text-black">

                    <img id="image-preview"
                         class="hidden mt-2 w-32 h-32 border rounded object-contain">
                </div>

            </div>

            <button type="submit"
                class="mt-4 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Save Product
            </button>
        </form>

        </div>



    <!-- PRODUCTS TABLE CARD -->
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6">

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Product List</h3>
        </div>

        <!-- Search -->
        <input type="text" id="search"
            placeholder="Search product..."
            class="mb-4 w-full p-2 border rounded text-black">

        <div class="overflow-x-auto">

        <table id="productsTable" class="w-full border rounded">

            <thead>
                <tr class="bg-green-100 text-black">
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Category</th>
                    <th class="p-3 text-left">Price</th>
                    <th class="p-3 text-left">Stock</th>
                    <th class="p-3 text-left">Edit</th>
                    <th class="p-3 text-left">View</th>
                    <th class="p-3 text-left">Delete</th>
                </tr>
            </thead>
<tbody>
@foreach($products as $product)
<tr class="border-b hover:bg-gray-50"
data-barcode="{{ $product->barcode }}">

<td class="p-3 product-name">{{ $product->name }}</td>

<td class="p-3">
    {{ $product->category->name ?? 'N/A' }}
</td>

<td class="p-3">
    FCFA {{ number_format($product->price,2) }}
</td>

<td class="p-3">
    @if($product->stock_quantity > 0)
        {{ $product->stock_quantity }}
    @else
        <span class="text-red-600 font-bold">Out of Stock</span>
    @endif
</td>

                    <td class="p-3">
                        <a href="{{ route('products.edit',$product) }}"
                           class="text-blue-600 hover:underline">
                           Edit
                        </a>
                    </td>

                    <td class="p-3">
                        <a href="{{ route('products.show',$product) }}"
                           class="text-blue-600 hover:underline">
                           View
                        </a>
                    </td>

                    <td class="p-3">
                        @if($product->saleItems->count() > 0)

                        <button onclick="alert('This product has been sold and cannot be deleted.')"
                            class="text-gray-400 cursor-not-allowed">
                            Delete
                        </button>

                        @else

                        <form method="POST"
                              action="{{ route('products.destroy',$product) }}">
                            @csrf
                            @method('DELETE')

                            <button
                                class="text-red-600 hover:underline"
                                onclick="return confirm('Delete this product?')">
                                Delete
                            </button>
                        </form>

                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>

        </div>
    </div>

</div>


<script>
const searchInput = document.getElementById("search");
const rows = document.querySelectorAll("#productsTable tbody tr");

searchInput.addEventListener("input", function(){

    let filter = this.value.toLowerCase();

    rows.forEach(row => {

        let nameCell = row.querySelector(".product-name");
        let name = nameCell.textContent.toLowerCase();
        let barcode = row.dataset.barcode ? row.dataset.barcode.toLowerCase() : "";

        if(name.includes(filter) || barcode.includes(filter)){

            row.style.display = "";

            if(filter.length > 0){
                let regex = new RegExp(`(${filter})`, "gi");
                nameCell.innerHTML = nameCell.textContent.replace(regex, "<span style='background:yellow'>$1</span>");
            }

        }else{
            row.style.display = "none";
        }

    });

});
</script>
@endsection