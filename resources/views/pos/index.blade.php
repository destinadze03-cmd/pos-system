@extends('layouts.pos')

@section('title', 'POS Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Products List -->
    <div class="md:col-span-2 bg-black p-4 rounded shadow">
        
        <!-- Barcode Input -->
        <input type="text"
               id="barcode-input"
               placeholder="Scan barcode..."
               class="w-full mb-4 p-2 border rounded text-black"
               autofocus>

        <!-- Product Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($products as $product)
        <button type="button"
                class="border rounded p-2 hover:shadow-lg hover:bg-gray-100 flex items-center gap-3 product-btn"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-price="{{ $product->price }}"
                data-stock="{{ $product->stock_quantity }}">

            <!-- Product Image -->
            <div class="w-16 h-16 flex-shrink-0 flex justify-center items-center overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-contain h-full w-full">
                @else
                    <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="object-contain h-full w-full">
                @endif
            </div>

            <!-- Product Name -->
            <p class="font-semibold truncate flex-1">{{ $product->name }}</p>

            <!-- Product Price -->
            <p class="text-blue font-medium">FCFA {{ number_format($product->price, 2) }}</p>

        </button>
        @endforeach
        </div>

    </div>

    <!-- Cart -->
    <div class="bg-black p-4 rounded shadow">
        <h2 class="font-semibold mb-3">Cart</h2>

        <form action="{{ route('pos.checkout') }}" method="POST" id="pos-form">
            @csrf

            <div class="space-y-2" id="cart-items"></div>

            <div class="border-t mt-4 pt-4">
                <p class="mb-2">
                    Total: <strong id="cart-total">FCFA 0.00</strong>
                </p>

                <p class="mb-2">
                    Change: <strong id="change-amount">FCFA 0.00</strong>
                </p>

                <input type="number"
                       id="amount-paid"
                       name="amount_paid"
                       placeholder="Amount Paid"
                       class="w-full p-2 border rounded mb-3 text-black"
                       required>

                <button type="submit"
                        class="w-full bg-green-600 text-blue py-2 rounded"
                        onclick="return validateCheckout()">
                    Complete Sale
                </button>
            </div>
        </form>
    </div>
</div>

<script>

const cart = {};
const cartItemsContainer = document.getElementById('cart-items');
const cartTotalEl = document.getElementById('cart-total');
const changeAmountEl = document.getElementById('change-amount');
const amountPaidInput = document.getElementById('amount-paid');
const barcodeInput = document.getElementById('barcode-input');

/* -------------------------
   PRODUCT BUTTON CLICK
--------------------------*/
document.querySelectorAll('.product-btn').forEach(btn => {
    btn.addEventListener('click', () => {

        const id = btn.dataset.id;
        const name = btn.dataset.name;
        const price = parseFloat(btn.dataset.price);
        const stock = parseInt(btn.dataset.stock);

        // 🚨 If stock is 0
        if (stock <= 0) {
            alert(name + " is out of stock!");
            return;
        }

        // 🚨 Prevent exceeding stock
        if (cart[id] && cart[id].quantity >= stock) {
            alert("Only " + stock + " item(s) available.");
            return;
        }

        if (!cart[id]) {
            cart[id] = { name, price, quantity: 1, stock: stock };
        } else {
            cart[id].quantity++;
        }

        renderCart();
    });
});

/* -------------------------
   BARCODE SCAN
--------------------------*/
barcodeInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const barcode = barcodeInput.value.trim();

        fetch(`/pos/product-by-barcode/${barcode}`)
            .then(response => {
                if (!response.ok) throw new Error('Product not found');
                return response.json();
            })
            .then(product => {

                if (product.stock_quantity <= 0) {
                    alert(product.name + " is out of stock!");
                    barcodeInput.value = '';
                    return;
                }

                if (!cart[product.id]) {
                    cart[product.id] = {
                        name: product.name,
                        price: parseFloat(product.price),
                        quantity: 1,
                        stock: product.stock_quantity
                    };
                } else {

                    if (cart[product.id].quantity >= product.stock_quantity) {
                        alert("Only " + product.stock_quantity + " item(s) available.");
                        barcodeInput.value = '';
                        return;
                    }

                    cart[product.id].quantity++;
                }

                renderCart();
                barcodeInput.value = '';
            })
            .catch(error => {
                alert(error.message);
                barcodeInput.value = '';
            });
    }
});

/* -------------------------
   RENDER CART
--------------------------*/
function renderCart() {

    cartItemsContainer.innerHTML = '';
    let total = 0;

    Object.keys(cart).forEach(id => {

        const item = cart[id];
        const subtotal = item.price * item.quantity;
        total += subtotal;

        cartItemsContainer.innerHTML += `
            <div class="flex justify-between items-center mb-2 border-b pb-2">
                
                <div>
                    <p class="font-semibold">${item.name}</p>
                    <p>FCFA ${item.price.toFixed(2)} x ${item.quantity}</p>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button"
                        onclick="decreaseQty(${id})"
                        class="bg-yellow-400 px-2 rounded">-</button>

                    <button type="button"
                        onclick="increaseQty(${id})"
                        class="bg-green-400 px-2 rounded">+</button>

                    <button type="button"
                        onclick="removeItem(${id})"
                        class="bg-red-500 text-white px-2 rounded">X</button>
                </div>

                <input type="hidden" name="products[${id}][quantity]" value="${item.quantity}">
                <input type="hidden" name="products[${id}][price]" value="${item.price}">
            </div>
        `;
    });

    cartTotalEl.textContent = 'FCFA ' + total.toFixed(2);
    calculateChange();
}

/* -------------------------
   QUANTITY CONTROLS
--------------------------*/
function increaseQty(id) {

    if (cart[id].quantity >= cart[id].stock) {
        alert("Cannot exceed available stock!");
        return;
    }

    cart[id].quantity++;
    renderCart();
}

function decreaseQty(id) {
    if (cart[id].quantity > 1) {
        cart[id].quantity--;
    } else {
        delete cart[id];
    }
    renderCart();
}

function removeItem(id) {
    delete cart[id];
    renderCart();
}

/* -------------------------
   CHANGE CALCULATION
--------------------------*/
amountPaidInput.addEventListener('input', calculateChange);

function calculateChange() {
    let total = 0;

    Object.keys(cart).forEach(id => {
        total += cart[id].price * cart[id].quantity;
    });

    const amountPaid = parseFloat(amountPaidInput.value) || 0;
    const change = amountPaid - total;

    changeAmountEl.textContent = "FCFA " + change.toFixed(2);

    if (change < 0) {
        changeAmountEl.classList.add("text-red-600");
    } else {
        changeAmountEl.classList.remove("text-red-600");
    }
}

/* -------------------------
   CHECKOUT VALIDATION
--------------------------*/
function validateCheckout() {

    if (Object.keys(cart).length === 0) {
        alert("Cart is empty!");
        return false;
    }

    let total = 0;
    Object.keys(cart).forEach(id => {
        total += cart[id].price * cart[id].quantity;
    });

    const paid = parseFloat(amountPaidInput.value) || 0;

    if (paid < total) {
        alert("Amount paid is less than total!");
        return false;
    }

    return true;
}

</script>

@endsection
