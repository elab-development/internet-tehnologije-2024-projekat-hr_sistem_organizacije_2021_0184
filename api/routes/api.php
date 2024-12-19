<?php

use App\Http\Controllers\TimController;
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

Route::resource('/projekti', \App\Http\Controllers\ProjekatController::class)->only(['index', 'show']);

Route::get('/clanovi-projekta/{projekatId}', [\App\Http\Controllers\ClanoviProjektaController::class, 'findByProjekat']);
Route::get('/projekti-clana/{clanId}', [\App\Http\Controllers\ClanoviProjektaController::class, 'findByClan']);

Route::get('/paginacija', [\App\Http\Controllers\ClanoviProjektaController::class, 'paginate']);

Route::get('/aktivnosti', [\App\Http\Controllers\AktivnostiController::class, 'index']);
Route::get('/aktivnosti/{id}', [\App\Http\Controllers\AktivnostiController::class, 'show']);

Route::get('/projekti-aktivnosti/{projekatId}', [\App\Http\Controllers\AktivnostiController::class, 'findByProjekat']);

Route::get('/aktivnosti-clana/{clanId}', [\App\Http\Controllers\AktivnostiClanaController::class, 'findByClan']);

//sanctum group
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/timovi', [TimController::class, 'vratiSveTimove']);


    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout']);

    Route::post('/timovi', [TimController::class, 'kreirajTim']);
    Route::put('/timovi/{id}', [TimController::class, 'azurirajTim']);
    Route::delete('/timovi/{id}', [TimController::class, 'obrisiTim']);

    Route::put('/clanovi/{id}', [\App\Http\Controllers\ClanController::class, 'update']);
    Route::delete('/clanovi/{id}', [\App\Http\Controllers\ClanController::class, 'destroy']);

    Route::resource('/projekti', \App\Http\Controllers\ProjekatController::class)->only(['store', 'update', 'destroy']);

    Route::post('/clanovi-projekta', [\App\Http\Controllers\ClanoviProjektaController::class, 'store']);
    Route::delete('/clanovi-projekta/{id}', [\App\Http\Controllers\ClanoviProjektaController::class, 'delete']);

    Route::post('/aktivnosti', [\App\Http\Controllers\AktivnostiController::class, 'store']);
    Route::delete('/aktivnosti/{id}', [\App\Http\Controllers\AktivnostiController::class, 'delete']);

    Route::post('/aktivnosti-clana', [\App\Http\Controllers\AktivnostiClanaController::class, 'store']);
    Route::delete('/aktivnosti-clana/{id}', [\App\Http\Controllers\AktivnostiClanaController::class, 'delete']);
});