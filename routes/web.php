<?php

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

Route::get('/', 'CartController@index');
Route::post('/', 'CartController@addItemstoCart');

Route::get('/cart', 'CartController@cart')->name('cart');
Route::post('/cart', 'CartController@removeItemsFromCart');
Route::post('/cart/checkout', 'CartController@mail')->name('checkout');

Route::get('/login', 'AuthController@login')->name('login');
Route::get('/logout', 'AuthController@logout');
Route::post('/login', 'AuthController@auth');

Route::get('/orders', 'OrdersController@orders')->middleware('admin.auth');
Route::get('/order', 'OrdersController@order')->middleware('admin.auth');

Route::resource('products', 'ProductsController')->middleware('admin.auth');
