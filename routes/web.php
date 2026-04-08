<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\MessageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('auth.login');
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard for both Admin and Cashier
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin-only routes
    Route::middleware(['role:admin'])->group(function () {
        // Users
        Route::resource('users', UserController::class);

        // Categories
        Route::resource('categories', CategoryController::class);
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');

        // Products
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
    });

    // POS routes - accessible by both roles
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::post('/pos/add-to-cart', [POSController::class, 'addToCart'])->name('pos.add-to-cart');
    Route::post('/pos/checkout', [POSController::class, 'checkout'])->name('pos.checkout');
    Route::get('/pos/product-by-barcode/{barcode}', [POSController::class, 'getProductByBarcode']);

    // Sales routes - accessible by both roles
    Route::resource('sales', SaleController::class)->only(['index', 'show']);
    Route::get('/receipt/{sale}', [SaleController::class, 'receipt'])->name('sales.receipt');
    Route::get('/sales/pdf', [SaleController::class, 'exportPdf'])->name('sales.pdf');
    Route::get('/Report/print', [SaleController::class, 'print'])->name('Report.print');

    // Purchases routes - accessible by both roles
    Route::resource('purchases', PurchaseController::class);
    Route::post('/purchases/add-stock/{id}', [PurchaseController::class, 'addStock'])->name('purchases.addStock');

Route::post('/purchases/send-to-products/{id}', [PurchaseController::class, 'sendToProducts'])
    ->name('purchases.sendToProducts');




Route::get('/stock-history', [StockMovementController::class, 'index'])->name('stock.history');

Route::post('/messages', [MessageController::class,'store'])->name('messages.store');









Route::get('/receipt/{id}', [SalesController::class, 'show'])->name('receipt.show');
});

require __DIR__ . '/auth.php';