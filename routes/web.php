<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\DirectMatchesController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('players.showPlayers');
})->name('index');

Route::get('/matches', [MatchesController::class, 'showMatches'])->name('matches.showMatches');
Route::get('/matches/add', [MatchesController::class, 'add'])->middleware(['auth'])->name('matches.add');
Route::post('/matches/add', [MatchesController::class, 'store'])->middleware(['auth'])->name('matches.store');
Route::get('/matches/{id}', [MatchesController::class, 'showMatch'])->name('matches.showMatch');

Route::get('/directmatches', [DirectMatchesController::class, 'showDirectMatches'])->name('directmatches.showDirectMatches');
Route::get('/directmatches/add', [DirectMatchesController::class, 'init'])->middleware(['auth'])->name('directmatches.add');
Route::post('/directmatches/add', [DirectMatchesController::class, 'create'])->middleware(['auth'])->name('directmatches.create');
Route::get('/directmatches/{id}', [DirectMatchesController::class, 'showDirectMatche'])->middleware(['auth'])->name('directmatches.showDirectMatche');
Route::post('/directmatches/{id}/update', [DirectMatchesController::class, 'update'])->middleware(['auth'])->name('directmatches.update');
Route::post('/directmatches/{id}/bet', [DirectMatchesController::class, 'bet'])->middleware(['auth'])->name('directmatches.bet');

Route::get('/players', [PlayersController::class, 'showPlayers'])->name('players.showPlayers');
Route::get('/players/{id}', [PlayersController::class, 'showPlayer'])->name('players.showPlayer');
