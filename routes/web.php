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

Route::get('/spa', function() {
    return view('spa');
});

Route::get('/', 'CartController@index')->name('index');
Route::post('/', 'CartController@addItemstoCart');

Route::get('/cart', 'CartController@cart')->name('cart');
Route::post('/cart', 'CartController@removeItemsFromCart')->name('cart.remove');
Route::post('/cart/checkout', 'CartController@mail')->name('checkout');

Route::get('/orders', 'OrdersController@orders')->name('orders')->middleware('auth');
Route::get('/order', 'OrdersController@order')->name('order')->middleware('auth');

Route::get('/product_details', 'CommentController@index')->name('productDetails');
Route::post('/product_details', 'CommentController@insertComments');

Route::get('/comments', 'CommentController@comments')->name('comments.index');
Route::delete('/comments/{id}', 'CommentController@destroy')->name('comments.delete');
Route::get('/comments_edit/{id}/edit', 'CommentController@edit')->name('comments.edit');
Route::put('/comments/{id}', 'CommentController@update')->name('comments.update');

Route::resource('products', 'ProductsController')->middleware('auth');

Auth::routes();

