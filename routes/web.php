<?php

use App\Http\Controllers\AddPlayersAjaxController;
use App\Http\Controllers\AddPlayersController;
use App\Http\Controllers\PlayersAjaxController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\PlayerStatsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamPlayersController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\TorunamentMatchesController;
use App\Http\Controllers\TournamentsAjaxController;
use App\Http\Controllers\TournamentsController;
use App\Http\Controllers\UsersController;
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
    Route::post('/tournaments/ajax', [TournamentsAjaxController::class, 'getData'])->name('frontend.tournaments.index');

    // USERS IMPORT AND EXPORT ROUTES
    Route::get('/export-skeleton-file',[UsersController::class,'export'])->name('export');
    Route::post('/import-users',[UsersController::class,'import'])->name('import');

});
Route::get('/players/{slug}/player-stats',[PlayerStatsController::class,'show'])->name('frontend.players.player-stats');

Route::get('/players',[PlayersController::class,'index'])->name('players.index');


// Route::get('/', function() {
//     return view('frontend')
// })
require __DIR__.'/auth.php';

Route::get('/register-via-email',function(){
    return view('frontend.players.register-email');
})->name('registration');

Route::post('/players/ajax', [PlayersAjaxController::class, 'getData'])->name('frontend.players.player-details');
Route::resource('players',PlayersController::class)->except('index', 'show');
Route::get('/register-player',[PlayersController::class,'validatePlayer'])->name('invite-player');
Route::resource('tournaments/{tournament}/teams/{team}/add-players', AddPlayersController::class)->except('show');
Route::get('tournaments/{tournament}/teams/{team}/add-players/invite-via-email', [AddPlayersController::class, 'inviteViaEmail'])->name('players.invite-via-email');
Route::post('tournaments/{tournament}/teams/{team}/add-players/players', [AddPlayersController::class, 'sendInvite'])->name('add-player.sendInvite');
Route::post('/players/ajax', [PlayersAjaxController::class, 'getData'])->name('frontend.players.add-player');
Route::post('/add-players/ajax', [AddPlayersAjaxController::class, 'getData'])->name('frontend.players.add-player');
Route::get('tournaments/{tournament}/schedule',[TorunamentMatchesController::class,'index'] )
->name('frontend.tournaments.schedule');
Route::post('tournaments/{tournament}/schedule',[TorunamentMatchesController::class,'store'])->name('tournaments.schedule.store');

