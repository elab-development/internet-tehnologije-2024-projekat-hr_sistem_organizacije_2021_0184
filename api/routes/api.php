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

Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\LoginController::class, 'register']);

Route::resource('/projekti', \App\Http\Controllers\ProjekatController::class)->only(['index', 'show']);
Route::get('/paginacija', [\App\Http\Controllers\ClanoviProjektaController::class, 'paginate']);

Route::get('/aktivnosti', [\App\Http\Controllers\AktivnostiController::class, 'index']);

//sanctum group
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/nepovezani-korisnici', [\App\Http\Controllers\LoginController::class, 'nepovezaniKorisnici']);
    Route::put('/promeni-ocenu/{id}', [\App\Http\Controllers\AktivnostiClanaController::class, 'promeniOcenu']);
    Route::get('aktivnosti-clana', [\App\Http\Controllers\AktivnostiClanaController::class, 'index']);

    Route::get('/clanovi-user/{userId}', [\App\Http\Controllers\ClanController::class, 'nadjiClanaPoUserIdu']);
    Route::get('/povezi/{clanId}/{userId}', [\App\Http\Controllers\ClanController::class, 'poveziUseraSaClanom']);

    Route::get('/clanovi-projekta/{projekatId}', [\App\Http\Controllers\ClanoviProjektaController::class, 'findByProjekat']);
    Route::get('/projekti-clana/{clanId}', [\App\Http\Controllers\ClanoviProjektaController::class, 'findByClan']);

    Route::get('/aktivnosti/{id}', [\App\Http\Controllers\AktivnostiController::class, 'show']);

    Route::get('/projekti-aktivnosti/{projekatId}', [\App\Http\Controllers\AktivnostiController::class, 'findByProjekat']);

    Route::get('/aktivnosti-clana/{clanId}', [\App\Http\Controllers\AktivnostiClanaController::class, 'findByClan']);

    Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout']);

    Route::post('/timovi', [TimController::class, 'kreirajTim'])->middleware(\App\Http\Middleware\AuthAdmin::class);
    Route::put('/timovi/{id}', [TimController::class, 'azurirajTim'])->middleware(\App\Http\Middleware\AuthAdmin::class);
    Route::delete('/timovi/{id}', [TimController::class, 'obrisiTim'])->middleware(\App\Http\Middleware\AuthAdmin::class);

    Route::post('/clanovi', [\App\Http\Controllers\ClanController::class, 'store'])->middleware(\App\Http\Middleware\AuthAdmin::class);
    Route::put('/clanovi/{id}', [\App\Http\Controllers\ClanController::class, 'update'])->middleware(\App\Http\Middleware\AuthAdmin::class);
    Route::delete('/clanovi/{id}', [\App\Http\Controllers\ClanController::class, 'destroy'])->middleware(\App\Http\Middleware\AuthAdmin::class);

    Route::resource('/projekti', \App\Http\Controllers\ProjekatController::class)->only(['store', 'update', 'destroy']);

    Route::post('/clanovi-projekta', [\App\Http\Controllers\ClanoviProjektaController::class, 'store']);
    Route::delete('/clanovi-projekta/{id}', [\App\Http\Controllers\ClanoviProjektaController::class, 'delete']);

    Route::post('/aktivnosti', [\App\Http\Controllers\AktivnostiController::class, 'store']);
    Route::delete('/aktivnosti/{id}', [\App\Http\Controllers\AktivnostiController::class, 'delete']);

    Route::post('/aktivnosti-clana', [\App\Http\Controllers\AktivnostiClanaController::class, 'store']);
    Route::delete('/aktivnosti-clana/{id}', [\App\Http\Controllers\AktivnostiClanaController::class, 'delete']);
});
