<?php

use App\Http\Controllers\Api\UserController;
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

Route::controller(UserController::class)->group(function(){
    Route::get('/users','index');
    Route::post('/user','store');
    Route::get('/user/{id}','show');
    Route::put('/user/{id}','update');
    Route::delete('/user/{id}','destroy');

    Route::post('/user/login','login');

    Route::put('/test/{id}', function () {
        return "asdasdasd";
    });
});
