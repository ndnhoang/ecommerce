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

//    Products Attribute
    Route::match(['get', 'post'], '/admin/add-attributes/{id}', 'ProductController@addAttributes');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
