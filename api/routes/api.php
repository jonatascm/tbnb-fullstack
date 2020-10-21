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

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 */

Route::apiResource('products', 'Api\ProductController');

Route::get('', [Api\ProductMovementController::class, 'index']);
Route::resource('/product_movements', 'Api\ProductMovementController')->only([
    'store', 'update', 'destroy'
]);

Route::post('/product_movements/batch-create', 'Api\ProductMovementController@batchCreate');


