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
Route::get('/login', [AuthController::class, 'getLogin'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('postLogin');
Route::post('/register', [AuthController::class, 'register'])->name('register');
// private
Route::get('/', function () { return view('base'); });
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
   
    // Route::get('/product', [ProductController::class, 'index'])->name('products');
    // Route::get('/customer', [CustomerController::class, 'index'])->name('customers');

});
// 
// Customer page
Route::controller(CustomerController::class)->group(function() {
    Route::get('customer', 'index')->name('customers');
    Route::get('customer/fetchData', 'fetchData');
    Route::post('customer/postCustomer', 'postCustomer');
    Route::get('customer/{customer_id}', 'show');


});


// Product page
Route::get('/product', [ProductController::class, 'index'])->name('products');

// User page
Route::controller(UserController::class)->group(function() {
    Route::get('user', 'index')->name('users');
    Route::get('user/fetchData', 'fetchData');
    Route::post('user/postUser', 'postUser');
    Route::get('user/delete/{id}', 'delete');
    Route::get('user/{id}', 'show');
    Route::get('user/status/{id}','setStatus')->name('setStatus');

});
