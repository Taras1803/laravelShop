<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.



Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    CRUD::resource('user', 'UserCrudController');
    CRUD::resource('categorie', 'CategorieCrudController');
    CRUD::resource('product', 'ProductCrudController');
    CRUD::resource('material', 'MaterialCrudController');
    CRUD::resource('products_attribute', 'Products_attributeCrudController');

}); // this should be the absolute last line of this file
//Route::post('/save-value-to-attribute', 'Products_attributeCrudController@saveValueAttribute');
