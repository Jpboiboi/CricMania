<?php

use App\Http\Controllers\AddPlayersAjaxController;
use App\Http\Controllers\AddPlayersController;
use App\Http\Controllers\PlayersAjaxController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\PlayerStatsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScorersController;
use App\Http\Controllers\TeamPlayersController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\TorunamentMatchesController;
use App\Http\Controllers\TournamentsAjaxController;
use App\Http\Controllers\TournamentsController;
use App\Http\Controllers\UsersController;
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


    // Add Player Ajax Routes
    Route::post('/add-players/ajax', [AddPlayersAjaxController::class, 'getData'])->name('frontend.players.add-player');
    // Add Player Routes
    Route::resource('tournaments/{tournament}/teams/{team}/add-players', AddPlayersController::class)->except(['show', 'update']);
    //Tournament_schedule store and view
    Route::get('tournaments/{tournament}/tournament_matches',[TorunamentMatchesController::class,'index'] )
    ->name('frontend.tournaments.schedule');
    Route::post('tournaments/{tournament}/tournament_matches/schedule',[TorunamentMatchesController::class,'store'])->name('tournaments.schedule.store');

});
Route::get('/players/{slug}/player-stats',[PlayerStatsController::class,'show'])->name('frontend.players.player-stats');

Route::get('/players',[PlayersController::class,'index'])->name('players.index');


// Route::get('/', function() {
    //     return view('frontend')
    // })
    require __DIR__.'/auth.php';


Route::post('/players/ajax', [PlayersAjaxController::class, 'getData'])->name('frontend.players.player-details');
Route::resource('players',PlayersController::class)->except('index', 'show');
Route::get('tournaments/{tournament}/teams/{team}/add-players/invite-via-email', [AddPlayersController::class, 'inviteViaEmail'])->name('players.invite-via-email');
Route::post('tournaments/{tournament}/teams/{team}/add-players/players', [AddPlayersController::class, 'sendInvite'])->name('add-player.sendInvite');
// Route::post('/players/ajax', [PlayersAjaxController::class, 'getData'])->name('frontend.players.add-player');
Route::post('/add-players/ajax', [AddPlayersAjaxController::class, 'getData'])->name('frontend.players.add-player');

// Register user using 'register as player' btn
Route::get('/register-via-email',function(){
    return view('frontend.users.register-email');
})->name('registration');
Route::resource('users',UsersController::class);
Route::get('/register-user',[UsersController::class,'validateUser']);

// Invite form to invite captain to teams through email
Route::get('tournaments/{tournament}/teams/{team}/invite-captain', [AddPlayersController::class, 'validateCaptain']);
// Storing invited captain details and adding captain to team
Route::post('tournaments/{tournament}/teams/{team}/invite-captain/users/{user}', [AddPlayersController::class, 'storeCaptain'])->name('addPlayers.storeCaptain');

// Invite form to invite player to teams through email
Route::get('/invite-user',[AddPlayersController::class,'validatePlayer']);
Route::get('tournaments/{tournament}/teams/{team}/add-players/invite-via-email', [AddPlayersController::class, 'inviteViaEmail'])->name('players.invite-via-email');

// Storing invited player details and adding player to team
Route::post('tournaments/{tournament}/teams/{team}/add-players/players', [AddPlayersController::class, 'sendInvite'])->name('add-player.sendInvite');
Route::put('/add-players/users/{user}',[AddPlayersController::class,'update'])->name('add-players.update');


Route::get('tournaments/{tournament}/schedule',[TorunamentMatchesController::class,'index'])->name('frontend.tournaments.schedule');
Route::post('tournaments/{tournament}/schedule',[TorunamentMatchesController::class,'store'])->name('tournaments.schedule.store');


//route for returning scorers view
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/scoring',[ScorersController::class,'scoring'])->name('scoring');
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/start-scoring',[ScorersController::class,'startScoring'])->name('start-scoring');
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/live-scoring',[ScorersController::class,'liveScoring'])->name('live-scoring');

Route::get('users/verify/{token}',[UsersController::class,'verify'])->name('verify');
Route::get('users/{user}/resend-verification',[Userscontroller::class,'resendVerification'])->name('resend-verification');

