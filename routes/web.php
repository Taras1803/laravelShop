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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/catalog', 'SiteController@index');
Route::get('/category/{slug}', 'CatalogController@category');
Route::get('/product/{slug}', 'CatalogController@product');
Route::resource('/products_attribute', 'AjaxProductsAttributeController');
Route::resource('/products_to_attribute', 'AjaxProductsToAttributeController');
Route::post('/get-attribute-values', 'AjaxProductsToAttributeController@actionGetAttributeValues');


Route::get('{page}/{subs?}', ['uses' => 'PageController@index'])
    ->where(['page' => '^((?!admin).)*$', 'subs' => '.*']);

