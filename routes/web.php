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

Route::get('/', 'ShopController@index');
Route::post('/', 'ShopController@addItemstoCart');

Route::get('/cart', 'ShopController@cart');
Route::post('/cart', 'ShopController@mail');

Route::get('/login', 'ShopController@login');
Route::get('/logout', 'ShopController@logout');
Route::post('/login', 'ShopController@auth');

Route::get('/orders', 'OrdersController@orders');
Route::get('/order', 'OrdersController@order');

Route::resource('products', 'ProductsController');
