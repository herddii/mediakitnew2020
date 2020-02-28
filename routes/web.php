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
Route::resource('/','Dashboard\IndexController');
        
// ini layout baru mediakit
Route::get('getIndex/{idkategori}','Dashboard\IndexController@getIndex');
Route::get('channel','Dashboard\IndexController@channel');
Route::get('tv-rating', 'Dashboard\IndexController@tv_rating');
Route::get('list_top_program', 'Dashboard\IndexController@list_top_program');
Route::post('market_share', 'Dashboard\IndexController@market_share');