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

Route::get('/', function () {
    return view('base');
});
Route::get('/product', [ProductController::class, 'index'])->name('products');
Route::get('/user', [UserController::class, 'index'])->name('users');
Route::get('/customer', [CustomerController::class, 'index'])->name('customers');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login', [AuthController::class, 'getLogin'])->name('getLogin');
Route::post('/login', [AuthController::class, 'postLogin'])->name('postLogin');

Route::post('/register', [AuthController::class, 'register'])->name('register');
// Route::get('/', [AuthController::class, 'index']);