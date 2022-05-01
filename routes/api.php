<?php

use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ReactionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ResponseController;
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
});

Route::controller(QuestionController::class)->group(function(){
    Route::get('/questions','index');
    Route::post('/question','store');
    Route::get('/question/{id}','show');
    Route::put('/question/{id}','update');
    Route::delete('/question/{id}','destroy');
    Route::get('/questionsByUser/{id}','questionsByUser');
    Route::get('/questionsBySearching/{searchingTerm}','questionsBySearching');
});

Route::controller(ResponseController::class)->group(function(){
    Route::get('/response','index');
    Route::post('/response','store');
    Route::get('/response/{id}','show');
    Route::put('/response/{id}','update');
    Route::delete('/response/{id}','destroy');
    Route::get('/responsesByQuestion/{id}','responsesByQuestion');

});

Route::controller(ReactionController::class)->group(function(){
    Route::get('/reaction','index');
    Route::post('/reaction','store');
    Route::get('/reaction/{id}','show');
    Route::put('/reaction/{id}','update');
    Route::delete('/reaction/{id}','destroy');
    Route::get('/reactionByResponse/{id}','reactionByResponse');
    Route::get('/reactionsByUserAndResponse/{user_id}/{response_id}','reactionsByUserAndResponse');
    Route::get('/likesByResponse/{id}','likesByResponse');
    Route::get('/unlikesByResponse/{id}','unlikesByResponse');
});
