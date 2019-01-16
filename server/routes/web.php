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

Route::post('login', 'Auth\LoginController@postLogin');
Route::get('loginCheck', 'Auth\LoginController@checkAuthenticationStatus');

// Game routes
Route::get('/fetchInitialState', 'InitialisationController@initialState');
