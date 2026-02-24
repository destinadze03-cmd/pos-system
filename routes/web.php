<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\SaleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


//dashboard
 
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');    
    

// Categories  
Route::resource('categories', CategoryController::class);       
// Products 
Route::get('products', [ProductController::class,'index'])->name('products.index');
//to create new product
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
   //to store created product
Route::post('/products', [ProductController::class, 'store'])->name('products.store'); // <--- important
//create category
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
//To store categories
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
//to edit product
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
//To Update prouduct
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
//To Delete Product
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
//To show a particular sale destail
Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
// showrecept
Route::get('/receipt/{receipt}', [SaleController::class, 'receipt'])->name('receipt.show');

//pos index
Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
Route::post('/pos/checkout', [POSController::class, 'checkout'])->name('pos.checkout');
// barcode route
Route::get('/pos/product-by-barcode/{barcode}', [PosController::class, 'getProductByBarcode']);

//print report
Route::get('/Report/print', [SaleController::class, 'print'])->name('Report.print');
//sale pdf
Route::get('/sales/pdf', [SaleController::class, 'exportPdf'])->name('sales.pdf');

//category index
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');


// edit category
Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');     

//search a product
Route::get('products/search', [ProductController::class, 'search'])->name('products.search');     
// POS 
Route::get('/pos', [POSController::class, 'index'])->name('pos.index');  
Route::post('/pos/add-to-cart', [POSController::class, 'addToCart'])->name('pos.add-to-cart');  
Route::post('/pos/checkout', [POSController::class, 'checkout'])->name('pos.checkout');      
// Sales  
Route::resource('sales', SaleController::class)->only(['index', 'show']); 
Route::get('/receipt/{sale}', [SaleController::class, 'receipt'])->name('sales.receipt');
});

//To show a particular product destail
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');















require __DIR__.'/auth.php';
