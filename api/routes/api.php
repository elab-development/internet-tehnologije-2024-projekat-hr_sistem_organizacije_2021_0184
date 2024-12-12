<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/timovi', [TimController::class, 'vratiSveTimove']);
Route::get('/timovi/{id}', [TimController::class, 'vratiTim']);

Route::get('/clanovi', [\App\Http\Controllers\ClanController::class, 'index']);
Route::get('/clanovi/{id}', [\App\Http\Controllers\ClanController::class, 'show']);
Route::get('/pretraga-po-timu/{timId}', [\App\Http\Controllers\ClanController::class, 'pretraziPoTimu']);
Route::get('/grupisi-po-timu', [\App\Http\Controllers\ClanController::class, 'grupisiPoTimu']);
Route::post('/clanovi', [\App\Http\Controllers\ClanController::class, 'store']);

Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\LoginController::class, 'register']);

//sanctum group
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout']);

    Route::post('/timovi', [TimController::class, 'kreirajTim']);
    Route::put('/timovi/{id}', [TimController::class, 'azurirajTim']);
    Route::delete('/timovi/{id}', [TimController::class, 'obrisiTim']);

    Route::put('/clanovi/{id}', [\App\Http\Controllers\ClanController::class, 'update']);
    Route::delete('/clanovi/{id}', [\App\Http\Controllers\ClanController::class, 'destroy']);
});
