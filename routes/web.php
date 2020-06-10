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

Route::get('/cart', 'CartController@cart');
Route::post('/cart', 'CartController@removeItemsFromCart');
Route::post('/cart/checkout', 'CartController@mail');

Route::get('/login', 'CartController@login');
Route::get('/logout', 'CartController@logout');
Route::post('/login', 'CartController@auth');

Route::get('/orders', 'OrdersController@orders');
Route::get('/order', 'OrdersController@order');

Route::resource('products', 'ProductsController');
