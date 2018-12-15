<?php

use Illuminate\Http\Request;
use App\Http\Middleware\ApiAuth;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('customers', 'CustomerController')->middleware(ApiAuth::class);
Route::apiResource('customers', 'CustomerController');
Route::apiResource('orders', 'OrdersController')->middleware(ApiAuth::class);
Route::apiResource('payments', 'PaymentsController')->middleware(ApiAuth::class);
Route::apiResource('expenses', 'ExpenseController')->middleware(ApiAuth::class);
Route::get('payments-graph', 'PaymentsController@graphdata')->middleware(ApiAuth::class);
Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::post('uploadimg', 'CustomerController@uploadImage');
Route::get('site_images/{filename}','CustomerController@image');
Route::delete('site_images/{filename}','CustomerController@deleteImage');
Route::delete('order_images/{id}','OrdersController@deleteOrderImage');

// Route::group(['prefix'=>'orders'],function(){
// 	Route::apiResource('/{order}/items','OrderItemsController');
// });
// // list Customers
// Route::get('customers', 'CustomerController@index');
// // list single Customer
// Route::get('customers/{id}', 'CustomerController@show');
// // Create new Customer
// Route::post('customers', 'CustomerController@store');
// // Delete Customer
// Route::delete('customers/{id}', 'CustomerController@destroy');

// // list Orders
// Route::get('orders', 'OrdersController@index');
// // list single Orders
// Route::get('orders/{id}', 'OrdersController@show');
// // Create new Order
// Route::post('orders', 'OrdersController@store');
// // Delete Order
// Route::delete('orders', 'OrdersController@destroy');
