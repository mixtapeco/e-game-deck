<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/games', 'App\Http\Controllers\GameController@index')->name('games.index');
Route::post('/games', 'App\Http\Controllers\GameController@store')->name('games.store');
Route::post('/games/{game_id}/vote', 'App\Http\Controllers\GameController@vote')->name('games.vote');