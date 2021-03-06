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

// Navigation
Route::post('/move', 'Game\Navigation\PositionController@move');
Route::post('/jump/{jump_node}', 'Game\Navigation\PositionController@jump');

Route::post('/dock/{dockable}', 'Game\Navigation\DockingController@dock');
Route::post('/undock/', 'Game\Navigation\DockingController@undock');

// Trading
Route::post('marketplace/buy', 'Game\Marketplace\TradingController@buy');
Route::post('marketplace/sell', 'Game\Marketplace\TradingController@sell');
Route::post('marketplace/get/{dockable}', 'Game\Marketplace\MarketController@get');
