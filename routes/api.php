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
route::post('/inscription',[userController::class,'inscription']);
//la route reservée pour la connection
route::post('/connecxion',[userController::class,'connection']);
//route pour afficher toutes les ressources


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
