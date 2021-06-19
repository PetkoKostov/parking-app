<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/test', function() {
    $now = date('Y-m-d H:i:s');
    echo $now;
});

Route::post('/vehicle-enter', 'ParkingController@enter');
Route::post('/vehicle-leave', 'ParkingController@leave');
Route::get('/available-spots', 'ParkingController@availableSpots');
Route::get('/check-bill', 'ParkingController@checkBill');

Route::fallback(function(){
    return response()->json(['message' => 'Not Found!'], 404);
});
