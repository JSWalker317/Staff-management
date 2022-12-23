<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// public
Route::get('/', function () { return view('base'); });

Route::get('/login', [AuthController::class, 'getLogin'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('postLogin');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// private

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Product page
    Route::controller(ProductController::class)
    ->prefix('product')
    ->as('product.')
    ->group(function() {
        Route::get('/', 'index')->name('products');
        // Route::get('/', 'index')->name('products');
        Route::get('/fetchData', 'fetchData')->name('fetchData');
        Route::get('/getViewPost', 'getViewPost')->name('getViewPost');
        // Route::post('product/postProduct', 'postProduct');
        Route::post('/storeProduct', 'storeProduct')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

 
    // Customer page
    Route::controller(CustomerController::class)
    ->prefix('customer')
    ->as('customer.')
    ->group(function() {
        Route::get('/', 'index')->name('customers');
        Route::get('/fetchData', 'fetchData')->name('fetchData');
        Route::get('/export', 'export')->name('export');
    
        Route::post('/postCustomer', 'postCustomer')->name('postCustomer');
        Route::post('/import','import')->name('import');
        Route::get('/{customer_id}', 'show')->name('show');
    });
 
    // User page
    Route::controller(UserController::class)
    ->prefix('user')
    ->as('user.')
    ->group(function() {
        Route::get('/', 'index')->name('users');
        Route::get('/fetchData', 'fetchData')->name('fetchData');
        Route::post('/postUser', 'postUser')->name('postUser');
    
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/status/{id}','setStatus')->name('setStatus');
    });
 

    // Route::get('/product', [ProductController::class, 'index'])->name('products');
    // Route::get('/customer', [CustomerController::class, 'index'])->name('customers');
});
