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
    return view('welcome');
});

Route::get('/export', function () {
    return view('export');
});

Route::post('/importListado', 'MainController@importListado');
Route::post('/importStock', 'MainController@importStock');

Route::get('/exportar', 'MainController@exportar');

Route::get('/products', 'ProductController@index')->name('products');
Route::get('/products/{id}/edit', 'ProductController@edit');
Route::post('/products/{id}', 'ProductController@update');

Route::get('/variants', 'VariantController@index')->name('variants');
Route::get('/variants/create', 'VariantController@create');
Route::post('/variants', 'VariantController@store');
Route::get('/variants/{id}/edit', 'VariantController@edit');
Route::post('/variants/{id}', 'VariantController@update');

Route::get('/categories', 'CategoryController@index')->name('categories');
Route::get('/categories/create', 'CategoryController@create');
Route::post('/categories', 'CategoryController@store');
Route::get('/categories/{id}/edit', 'CategoryController@edit');
Route::post('/categories/{id}', 'CategoryController@update');
Route::get('/categories/{id}/delete', 'CategoryController@delete');
Route::get('/categories/{id}/products', 'CategoryController@showProducts');

Route::get('/corrector', 'MainController@corrector');

Route::get('/test', function(){
    Spatie\DbDumper\Databases\MySql::create()
    ->setDbName(env('DB_DATABASE'))
    ->setUserName(env('DB_USERNAME'))
    ->setPassword(env('DB_PASSWORD'))
    ->dumpToFile('dump.sql');
});
