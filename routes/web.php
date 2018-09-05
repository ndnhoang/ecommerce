<?php

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
    return view('welcome');
});

Route::match(['get', 'post'], '/admin', 'AdminController@login');


Route::get('/logout', 'AdminController@logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin/dashboard', 'AdminController@dashboard');
    Route::get('/admin/setting', 'AdminController@setting');
    Route::get('/admin/check-pwd', 'AdminController@checkPassword');
    Route::match(['get', 'post'], '/admin/update-pwd', 'AdminController@updatePassword');

//    Categories Route (Admin)
    Route::match(['get', 'post'], '/admin/add-category', 'CategoryController@addCategory');
    Route::get('/admin/view-categories', 'CategoryController@viewCategories');
    Route::match(['get', 'post'], '/admin/edit-category/{id}', 'CategoryController@editCategory');
    Route::match(['get', 'post'], '/admin/delete-category/{id}', 'CategoryController@deleteCategory');

//    Product Route (Admin)
    Route::match(['get', 'post'], '/admin/add-product', 'ProductController@addProduct');
    Route::get('/admin/view-products', 'ProductController@viewProducts');
    Route::match(['get', 'post'], '/admin/edit-product/{id}', 'ProductController@editProduct');
    Route::get('/admin/delete-product-image/{id}', 'ProductController@deleteProductImage');
    Route::get('/admin/delete-product/{id}', 'ProductController@deleteProduct');
    Route::match(['get', 'post'], '/admin/add-images/{id}', 'ProductController@addImages');
    Route::get('/admin/delete-images/{id}', 'ProductController@deleteImages');


//    Products Attribute
    Route::match(['get', 'post'], '/admin/add-attributes/{id}', 'ProductController@addAttributes');
    Route::get('/admin/delete-attribute/{id}', 'ProductController@deleteAttribute');
    Route::match(['get', 'post'], '/admin/edit-attributes/{id}', 'ProductController@editAttributes');
});

//Front Route

Route::get('/', 'IndexController@index');
Route::get('/category/{id}', 'ProductController@listProductsByCategory');
Route::get('/product/{id}', 'ProductController@showProductDetails');
//get product price by size
Route::get('/get-price', 'ProductController@getProductPrice');
//cart
Route::match(['get', 'post'], '/add-cart', 'ProductController@addCart');
Route::match(['get', 'post'], '/cart', 'ProductController@showCart');
Route::get('/cart/delete-product/{id}', 'ProductController@deleteCartProduct');
Route::get('/cart/update-quantity/{id}/{quantity}', 'ProductController@updateCartQuantity');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
