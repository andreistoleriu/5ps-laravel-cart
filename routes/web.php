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
Route::post('/cart/checkout', 'CartController@mail')->name('cart.checkout');

Route::get('/orders', 'OrderController@index')->name('orders.index')->middleware('auth');
Route::get('/orders/{order}', 'OrderController@show')->name('orders.show')->middleware('auth');

Route::get('/product_details', 'CommentController@index')->name('productDetails.index');
Route::post('/product_details', 'CommentController@create')->name('productDetails.create');

Route::get('/comments', 'CommentController@comments')->name('comments.index')->middleware('auth');
Route::delete('/comments/{comment}', 'CommentController@destroy')->name('comments.destroy')->middleware('auth');
Route::get('/comments_edit/{comment}/edit', 'CommentController@edit')->name('comments.edit')->middleware('auth');
Route::put('/comments/{comment}', 'CommentController@update')->name('comments.update')->middleware('auth');

Route::resource('products', 'ProductController')->middleware('auth');

Auth::routes();

