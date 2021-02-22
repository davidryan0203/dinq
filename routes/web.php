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
Route::post('/venue/edit-info/{id}', 'VenueController@edit');
Route::get('/venue/edit/{id}', 'VenueController@editVenue');
Route::get('/get-venue', 'VenueController@getVenues');
Route::get('/get-user-details', 'HomeController@getUserDetails');
Route::get('/get-customers', 'HomeController@getCustomers');

Route::get('/admin-venue', 'VenueController@adminVenue');
Route::get('/admin-supplier', 'SupplierController@adminSupplier');
Route::get('/get-all-venues', 'VenueController@getAllVenues');
Route::get('/get-supplier-venues', 'VenueController@getSupplierVenues');

//Supplier
Route::get('/supplier', 'SupplierController@supplier');
Route::post('/supplier/edit/{id}', 'SupplierController@edit');
Route::get('/get-suppliers', 'SupplierController@getSupplier');

Route::get('/menu/category', 'MenuItemController@index');
Route::get('/menu-category-item/get', 'MenuItemController@getMenuCategoryItems');
Route::post('/menu-category-item/save', 'MenuItemController@saveMenuCategoryItem');


Route::get('/menu/items', 'MenuItemController@menuItem');
Route::get('/menu-items/get', 'MenuItemController@getMenuItems');
Route::post('/menu-items/filter', 'MenuItemController@filterMenuItems');

Route::post('/menu-items/save', 'MenuItemController@saveMenuItem');
Route::post('/menu-items/delete', 'MenuItemController@deleteMenuItem');

Route::get('/activities', 'HomeController@activities');
Route::get('/get-activities', 'HomeController@getActivities');

Route::get('/admin-menu-items/{id}', 'MenuItemController@getAdminMenuItems');
Route::get('/admin-menu-category-item/{id}', 'MenuItemController@getAdminMenuCategory');
Route::get('/admin-menu/mixer/{id}', 'MenuItemController@getAdminMenuMixers');

Route::get('/menu/add-on', 'MenuItemController@menuMixer');
Route::get('/menu/mixer/get', 'MenuItemController@getMenuMixer');
Route::post('/menu/mixer/save', 'MenuItemController@saveMixerDetails');
Route::post('/mixer/upload', 'MenuItemController@mixerUpload');

Route::get('/orders/', 'OrdersController@index');
Route::get('/get-orders/', 'OrdersController@getOrders');
Route::post('/place-orders/', 'OrdersController@placeOrders');

Route::post('/store-payment-info', 'PaymentsController@storePaymentInfo');
Route::post('/store-payment-info-checkout', 'PaymentsController@storePaymentInfoCheckout');

Route::post('/remove-payment-info', 'PaymentsController@removePaymentInfo');

Route::get('/get-exchange-rates/', 'HomeController@getExchangeRates');
Route::post('/process-order', 'PaymentsController@processOrder');
Route::get('/pay-order/', 'PaymentsController@payOrder');

Route::post('/venue/edit-general/{id}', 'VenueController@editGeneral');
Route::post('/venue/edit-data/{id}', 'VenueController@editData');
Route::post('/venue/edit-bank/{id}', 'VenueController@editBank');
Route::post('/venue/edit-option/{id}', 'VenueController@editOption');
Route::get('/venue/remove/{id}', 'VenueController@removeVenue');
Route::get('/venue/reactivate/{id}', 'VenueController@reactivateVenue');
Route::get('/supplier/remove/{id}', 'SupplierController@removeSupplier');
Route::get('/supplier/reactivate/{id}', 'SupplierController@reactivateSupplier');
Route::get('/supplier/edit/{id}', 'SupplierController@editSupplier');
Route::get('/get-tax-rates', 'VenueController@getTaxRates');
Route::get('/customers', 'HomeController@customers');
Route::get('/waiter', 'HomeController@waiter');
Route::post('/redeem-coupon', 'OrdersController@redeemCoupon');

Route::get('/tax-rates', 'TaxRatesController@taxRates');
Route::get('/get-tax-rates', 'TaxRatesController@getTaxRates');
Route::post('/save-tax-rate', 'TaxRatesController@saveTaxRate');
Route::post('/remove-tax-rate', 'TaxRatesController@removeTaxRate');

Route::get('/get-waiters', 'WaiterController@getWaiter');
Route::post('/save-waiter-data', 'WaiterController@saveWaiterData');
Route::post('/waiter/upload', 'WaiterController@waiterUpload');

Route::get('/admin-menu-items', 'MenuItemController@adminMenuItems');

Route::get('get-revenue', 'HomeController@getRevenue');
Route::get('get-redeemed', 'HomeController@getRedeemed');
Route::get('get-pending-orders', 'HomeController@getPendingOrders');
Route::get('get-todays-checkins', 'HomeController@getTodaysCheckins');

Route::get('get-countries', 'HomeController@getCountries');
Route::get('test-payment', 'PaymentsController@testPayment');

Route::post('deactivate-customer', 'HomeController@deactivateCustomer');
Route::post('reactivate-customer', 'HomeController@reactivateCustomer');
Route::get('social-media/feeds', 'FeedsController@feeds');
Route::get('/get-feeds', 'FeedsController@get');
Route::get('/get-checkins', 'FeedsController@getCheckIns');
Route::get('/social-media/checkins', 'FeedsController@checkins');



Route::get('simple-qr-code', function () {
     return QrCode::size(200)->generate('W3Adda Laravel Tutorialsfdafafdafdagsssafa');
});

Route::get('qr-scanner', function () {
    
  return view('qr-scanner');
});