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

Route::get('/', 'UsersController@index');
Route::post('/', 'UsersController@store');

Route::get('user/{id}/edit', 'UsersController@edit');
Route::patch('user/{id}', 'UsersController@update');

Route::delete('user/{id}', 'UsersController@destroy');
