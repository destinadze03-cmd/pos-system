@extends('layouts.pos')

@section('title', 'POS Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Products List -->
    <div class="md:col-span-2 bg-black p-4 rounded shadow text-white ">
        
        <!-- Unified Barcode/Search Input -->
        <input type="text"
               id="product-input"
               placeholder="Scan barcode or search by name..."
               class="w-full mb-4 p-2 border rounded text-black"
               autofocus>

        <!-- Product Buttons -->
        <div class=" grid grid-cols-1 md:grid-cols-2 gap-4" id="product-list">
            @foreach($products as $product)
            <button type="button"
                    class="border rounded p-2 hover:shadow-lg hover:bg-gray-100 flex items-center gap-3 product-btn"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-barcode="{{ $product->barcode ?? '' }}"
                    data-price="{{ $product->price }}"
                    data-stock="{{ $product->stock_quantity }}">

                <!-- Product Image -->
                <div class="w-16 h-16 flex-shrink-0 flex justify-center items-center overflow-hidden">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="object-contain h-full w-full">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="object-contain h-full w-full text-gray-600">
                    @endif
                </div>

                <!-- Product Name -->
                <p class="font-semibold truncate flex-1 text-gray-700">{{ $product->name }}</p>

                <!-- Product Price -->
                <p class="text-blue-600 font-medium">FCFA {{ number_format($product->price, 2) }}</p>

            </button>
            @endforeach
        </div>

    </div>

    <!-- Cart -->
    <div class="bg-black p-4 rounded shadow text-gray">
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

                 <label for="payment_method">Select Payment Method:</label>
<select name="payment_method" id="payment_method" required>
    <option value="">-- Choose Payment Method --</option>
    <option value="cash">Cash</option>
    <option value="credit_card">Credit Card</option>
    <option value="bank_transfer">Bank Transfer</option>
    <option value="mobile_money">Mobile Money</option>
    <option value="paypal">PayPal</option>
    <option value="cheque">Cheque</option>
</select>

                <input type="number"
                       id="amount-paid"
                       name="amount_paid"
                       placeholder="Amount Paid"
                       class="w-full p-2 border rounded mb-3 text-black"
                       required>

                <button type="submit"
                        class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700"
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
const productInput = document.getElementById('product-input');
const productButtons = document.querySelectorAll('.product-btn');

// -------------------------
// PRODUCT BUTTON CLICK
// -------------------------
productButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        const name = btn.dataset.name;
        const price = parseFloat(btn.dataset.price);
        const stock = parseInt(btn.dataset.stock);

        if (stock <= 0) {
            alert(`${name} is out of stock!`);
            return;
        }

        if (!cart[id]) {
            cart[id] = { name, price, quantity: 1, stock };
        } else if (cart[id].quantity < stock) {
            cart[id].quantity++;
        } else {
            alert(`Only ${stock} item(s) available.`);
            return;
        }

        renderCart();
    });
});

// -------------------------
// UNIFIED SEARCH / BARCODE
// -------------------------
productInput.addEventListener('input', () => {
    const query = productInput.value.toLowerCase();
    productButtons.forEach(btn => {
        const name = btn.dataset.name.toLowerCase();
        const barcode = (btn.dataset.barcode || '').toLowerCase();
        btn.style.display = (name.includes(query) || barcode.includes(query)) ? 'flex' : 'none';
    });
});

productInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const inputValue = productInput.value.trim();
        if (!inputValue) return;

        // If numeric, treat as barcode scan
        if (!isNaN(inputValue)) {
            fetch(`/pos/product-by-barcode/${inputValue}`)
                .then(res => { if (!res.ok) throw new Error('Product not found'); return res.json(); })
                .then(product => {
                    addToCart(product.id, {
                        id: product.id,
                        name: product.name,
                        price: parseFloat(product.price),
                        stock: product.stock_quantity
                    });
                    productInput.value = '';
                })
                .catch(err => { alert(err.message); productInput.value = ''; });
        }
    }
});

// -------------------------
// ADD TO CART FUNCTION
// -------------------------
function addToCart(id, product) {
    if (!cart[id]) {
        cart[id] = { ...product, quantity: 1 };
    } else if (cart[id].quantity < product.stock) {
        cart[id].quantity++;
    } else {
        alert(`Only ${product.stock} item(s) available.`);
        return;
    }
    renderCart();
}

// -------------------------
// RENDER CART
// -------------------------
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
                    <button type="button" onclick="decreaseQty(${id})" class="bg-yellow-400 px-2 rounded">-</button>
                    <button type="button" onclick="increaseQty(${id})" class="bg-green-400 px-2 rounded">+</button>
                    <button type="button" onclick="removeItem(${id})" class="bg-red-500 text-white px-2 rounded">X</button>
                </div>

                <input type="hidden" name="products[${id}][quantity]" value="${item.quantity}">
                <input type="hidden" name="products[${id}][price]" value="${item.price}">
            </div>
        `;
    });

    cartTotalEl.textContent = 'FCFA ' + total.toFixed(2);
    calculateChange();
}

// -------------------------
// QUANTITY CONTROLS
// -------------------------
function increaseQty(id) {
    if (cart[id].quantity < cart[id].stock) {
        cart[id].quantity++;
    } else {
        alert("Cannot exceed available stock!");
    }
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

// -------------------------
// CHANGE CALCULATION
// -------------------------
amountPaidInput.addEventListener('input', calculateChange);

function calculateChange() {
    let total = 0;
    Object.keys(cart).forEach(id => total += cart[id].price * cart[id].quantity);

    const paid = parseFloat(amountPaidInput.value) || 0;
    const change = paid - total;

    changeAmountEl.textContent = "FCFA " + change.toFixed(2);
    changeAmountEl.classList.toggle("text-red-600", change < 0);
}

// -------------------------
// CHECKOUT VALIDATION
// -------------------------
function validateCheckout() {
    if (Object.keys(cart).length === 0) {
        alert("Cart is empty!");
        return false;
    }

    const total = Object.keys(cart).reduce((sum, id) => sum + cart[id].price * cart[id].quantity, 0);
    const paid = parseFloat(amountPaidInput.value) || 0;

    if (paid < total) {
        alert("Amount paid is less than total!");
        return false;
    }

    return true;
}
</script>
@endsection