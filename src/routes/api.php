<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('cache/clear', 'ApiController@clearCache');
Route::post('cache/clear', 'ApiController@clearCache');

Route::get('cache/warm', 'ApiController@warmCache');
Route::post('cache/warm', 'ApiController@warmCache');

Route::get('cache/publish', 'ApiController@publishCache');
Route::post('cache/publish', 'ApiController@publishCache');

Route::get('sitemap/generate', 'ApiController@generateSitemap');
Route::post('sitemap/generate', 'ApiController@generateSitemap');
