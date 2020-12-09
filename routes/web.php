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

Route::get('/', function () {
    return view('home');
});

Auth::routes();
// orders
Route::get('/order-login', 'OrderController@orderLogin')->name('order-login');
Route::post('/order-auth', 'Auth\LoginController@orderLogin')->name('order-auth');
Route::get('/order-shipping', 'OrderController@orderShipping')->name('order-shipping');
Route::post('/order-customer-data', 'OrderController@orderCustomerData')->name('order-customer-data');
Route::get('/order-confirm', 'OrderController@orderConfirm')->name('order-confirm');
Route::get('/create-order', 'OrderController@createOrder')->name('create-order');

// dev
Route::get('/dev', 'HomeController@dev')->name('dev');

// product
Route::get('/product-image/{fileName}/{color?}/{extraPicture?}', 'ProductController@getProductImage')->name('product-image');
Route::get('/products/{searchText?}', 'ProductController@searchProductsIndex')->name('search-products-index');
Route::get('/products/{minimumPrice}/{maximumPrice}/{text}/{selectedCategories}/{selectedFilters}/{discountFilter}/{page}/{changed?}', 'ProductController@searchProducts')->name('search-products');
Route::get('/product/{id}', 'ProductController@displayProductDetails')->name('display-product-details');

// user
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/orders/{page?}', 'HomeController@userOrders')->name('user-orders');
Route::get('/user/order/{id}', 'HomeController@userOrderDetails')->name('user-order-details');
Route::get('/user/data', 'HomeController@userData')->name('user-data');
Route::post('/user/data/save', 'HomeController@saveUserData')->name('user-data');


// cart
Route::get('/cart', 'CartController@displayCart')->name('display-cart');
Route::post('/add-to-cart', 'CartController@addToCart')->name('add-to-cart');
Route::post('/modify-cart-item', 'CartController@modifyCartItem')->name('modify-cart-item');
Route::post('/remove-cart-item', 'CartController@removeCartItem')->name('remove-cart-item');

// admin
Route::name('admin')->middleware(['auth', 'can:admin'])->group(function () {
    // orders
    Route::get('/admin/orders/{page?}', 'AdminController@orders')->name('admin-orders');
    Route::get('/admin/order/{id}', 'AdminController@orderDetails')->name('admin-order-details');
    Route::post('/admin/modify-order', 'AdminController@modifyOrder')->name('modify-order');
    Route::post('/admin/send-order-status-email', 'AdminController@sendOrderStatusEmail')->name('send-order-status-email');
    
    // categories
    Route::get('/admin/categories', 'AdminController@categories')->name('categories');
    Route::post('/admin/remove-category', 'AdminController@removeCategory')->name('remove-category');
    Route::post('/admin/modify-category', 'AdminController@modifyCategory')->name('modify-category');
    Route::post('/admin/create-category', 'AdminController@createCategory')->name('create-category');

    // products
    Route::get('/admin/products/{page?}', 'AdminController@products')->name('admin-products');
    Route::get('/admin/create-product', 'AdminController@createProduct')->name('create-product');
    Route::get('/admin/edit-product/{id}', 'AdminController@editProduct')->name('edit-product');
    Route::post('/admin/modify-product', 'AdminController@modifyProduct')->name('modify-product');
    Route::post('/admin/upload-product-images', 'ProductController@uploadProductImages')->name('upload-product-image');
    Route::get('/admin/copy-product/{id}', 'AdminController@copyProduct')->name('copy-product');
});