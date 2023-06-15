<?php

use App\Http\Controllers\PlayersController;
use App\Http\Controllers\PlayerStatsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TournamentsAjaxController;
use App\Http\Controllers\TournamentsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
})->name('frontend.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('tournaments', TournamentsController::class)->only('create', 'store', 'index');
    Route::post('/tournaments/ajax', [TournamentsAjaxController::class, 'getData'])->name('frontend.tournaments.index');
});
Route::get('/players/{player}/player-stats',[PlayerStatsController::class,'show'])->name('frontend.player-stats');
Route::get('/players',[PlayersController::class,'index'])->name('frontend.players');

// Route::get('/', function() {
//     return view('frontend')
// })
require __DIR__.'/auth.php';
