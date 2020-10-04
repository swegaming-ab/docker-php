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

if(config('prismic.preview')) {
    Route::get('/preview', 'ContentController@preview');
}

Route::get('/', 'ContentController@index');

Route::get('/{locale}', 'ContentController@home');

// Redirect url
Route::get('/{locale}/go/{key}', 'ContentController@redirect');

// maximum 5 childs deep...
// TODO must be able to do this better
Route::get('/{locale}/{path1?}/{path2?}/{path3?}/{path4?}/{path5?}', 'ContentController@localePage');
