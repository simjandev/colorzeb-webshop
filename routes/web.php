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
Route::get('/order-login', 'OrderController@orderLogin')->name('order-login');
Route::post('/order-auth', 'Auth\LoginController@orderLogin')->name('order-auth');
Route::get('/order-shipping', 'OrderController@orderShipping')->name('order-shipping');
Route::post('/order-customer-data', 'OrderController@orderCustomerData')->name('order-customer-data');
Route::get('/order-confirm', 'OrderController@orderConfirm')->name('order-confirm');

Route::get('/dev', 'HomeController@dev')->name('dev');
Route::get('/product-image/{fileName}/{color?}/{extraPicture?}', 'ProductController@getProductImage')->name('product-image');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/products/{page?}', 'ProductController@searchProductsIndex')->name('search-products-index');
Route::get('/products/{minimumPrice}/{maximumPrice}/{text}/{selectedCategories}/{selectedFilters}/{discountFilter}/{page}/{changed?}', 'ProductController@searchProducts')->name('search-products');
Route::get('/product/{id}', 'ProductController@displayProductDetails')->name('display-product-details');
Route::get('/cart', 'CartController@displayCart')->name('display-cart');

Route::post('/add-to-cart', 'CartController@addToCart')->name('add-to-cart');
Route::post('/modify-cart-item', 'CartController@modifyCartItem')->name('modify-cart-item');
Route::post('/remove-cart-item', 'CartController@removeCartItem')->name('remove-cart-item');



// admin
Route::name('admin')->middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/admin/orders', 'AdminController@orders')->name('orders');
    
    // categories
    Route::get('/admin/categories', 'AdminController@categories')->name('categories');
    Route::post('/admin/remove-category', 'AdminController@removeCategory')->name('remove-category');
    Route::post('/admin/modify-category', 'AdminController@modifyCategory')->name('modify-category');
    Route::post('/admin/create-category', 'AdminController@createCategory')->name('create-category');

    // products
    Route::get('/admin/products', 'AdminController@products')->name('products');
    Route::get('/admin/create-product', 'AdminController@createProduct')->name('create-product');
    Route::get('/admin/edit-product/{id}', 'AdminController@editProduct')->name('edit-product');
    Route::post('/admin/modify-product', 'AdminController@modifyProduct')->name('modify-product');
    Route::post('/admin/upload-product-images', 'ProductController@uploadProductImage')->name('upload-product-image');
    Route::get('/admin/copy-product/{id}', 'AdminController@copyProduct')->name('copy-product');
});