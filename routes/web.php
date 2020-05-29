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

Route::get('/', 'PageController@index');
Route::get('/cart', 'PageController@cart');
Route::get('/login', 'PageController@login');
Route::get('/product', 'PageController@product');
Route::get('/products', 'PageController@products');
Route::get('/orders', 'PageController@orders');

Route::resource('products', 'ProductsController');
