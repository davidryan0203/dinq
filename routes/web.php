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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/', 'WelcomeController@index');
Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('/test-email', 'HomeController@testEmail')->name('home');

//Venue
Route::get('/venue', 'VenueController@index');
Route::post('/venue/edit', 'VenueController@edit');


Route::get('/menu/category', 'MenuItemController@index');
Route::get('/menu-category-item/get', 'MenuItemController@getMenuCategoryItems');
Route::post('/menu-category-item/save', 'MenuItemController@saveMenuCategoryItem');


Route::get('/menu/items', 'MenuItemController@menuItem');
Route::get('/menu-items/get', 'MenuItemController@getMenuItems');
Route::post('/menu-items/save', 'MenuItemController@saveMenuItem');
Route::post('/menu-items/delete', 'MenuItemController@deleteMenuItem');

Route::get('/menu/mixer', 'MenuItemController@menuMixer');
Route::get('/menu/mixer/get', 'MenuItemController@getMenuMixer');
Route::post('/menu/mixer/save', 'MenuItemController@saveMixerDetails');
Route::post('/mixer/upload', 'MenuItemController@mixerUpload');

Route::get('/orders/', 'OrdersController@index');
Route::get('/get-orders/', 'OrdersController@getOrders');
Route::post('/place-orders/', 'OrdersController@placeOrders');