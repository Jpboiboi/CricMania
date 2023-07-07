<?php

use App\Http\Controllers\AddPlayersController;
use App\Http\Controllers\PlayersAjaxController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\PlayerStatsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScorersController;
use App\Http\Controllers\TeamPlayersController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\TournamentsAjaxController;
use App\Http\Controllers\TournamentsController;
use App\Models\Player;
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
    Route::resource('tournaments/{tournament}/teams', TeamsController::class);

    Route::resource('scorer', ScorersController::class);
    // Route::resource('scorer/matches/matchid', ScorersController::class);

    Route::post('/tournaments/ajax', [TournamentsAjaxController::class, 'getData'])->name('frontend.tournaments.index');
});
Route::get('/players/{slug}/player-stats',[PlayerStatsController::class,'show'])->name('frontend.players.player-stats');

Route::get('/players',[PlayersController::class,'index'])->name('frontend.players.player-details');


// Route::get('/', function() {
//     return view('frontend')
// })
require __DIR__.'/auth.php';

Route::get('/register-via-email',function(){
    return view('frontend.players.register-email');
})->name('registration');

Route::resource('players',PlayersController::class)->except('index');
Route::get('/register-player',[PlayersController::class,'validatePlayer'])->name('invite-player');
Route::resource('tournaments/{tournament}/teams/{team}/add-players', AddPlayersController::class)->except('show');
Route::get('tournaments/{tournament}/teams/{team}/add-players/invite-via-email', [AddPlayersController::class, 'inviteViaEmail'])->name('players.invite-via-email');
Route::post('tournaments/{tournament}/teams/{team}/add-players/players', [AddPlayersController::class, 'sendInvite'])->name('add-player.sendInvite');
Route::post('/players/ajax', [PlayersAjaxController::class, 'getData'])->name('frontend.players.add-player');
