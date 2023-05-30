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

Route::post('/register', [\App\Http\Controllers\Controller::class, 'register']);
Route::post('/addTicket', [\App\Http\Controllers\Controller::class, 'addTicket']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/getTickets', [\App\Http\Controllers\Controller::class, 'getTickets']);
    Route::post('/reply/{id}', [\App\Http\Controllers\Controller::class, 'reply']);
});
