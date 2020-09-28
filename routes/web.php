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

Route::get('/export', function () {
    return view('export');
});

Route::post('importListado', 'MainController@importListado');
Route::post('importStock', 'MainController@importStock');

Route::get('exportar', 'MainController@exportar');

Route::get('/products','ProductController@index')->name('products');
Route::get('/products/{id}/edit','ProductController@edit');
Route::post('/products/{id}','ProductController@update');

Route::get('variants', 'VariantController@index')->name('variants');
Route::get('variants/create', 'VariantController@create');
Route::post('variants', 'VariantController@store');
Route::get('variants/{id}/edit', 'VariantController@edit');
Route::post('variants/{id}', 'VariantController@update');

Route::get('corrector', 'MainController@corrector');