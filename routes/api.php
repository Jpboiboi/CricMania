<?php

use App\Http\Controllers\MatchDetailScorecardsController;
use App\Http\Controllers\MatchScorecardsController;
use App\Http\Controllers\TorunamentMatchesController;
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

// Update toss or currently_batting team depending on query params
Route::put('tournament/{tournament}/tournament_matches/{tournament_match}/update',[ TorunamentMatchesController::class, 'update']);

// Get all players of team 1 of a match
Route::get('tournament/{tournament}/tournament_matches/{tournament_match}/team1_players',[ TorunamentMatchesController::class, 'getTeam1Players']);
// Set playing eleven players of team 1 of a match
Route::put('tournament/{tournament}/tournament_matches/{tournament_match}/team1_players',[ TorunamentMatchesController::class, 'setPlayingElevenOfTeam1']);

// Get all players of team 2 of a match
Route::get('tournament/{tournament}/tournament_matches/{tournament_match}/team2_players',[ TorunamentMatchesController::class, 'getTeam2Players']);
// Set playing eleven players of team 2 of a match
Route::put('tournament/{tournament}/tournament_matches/{tournament_match}/team2_players',[ TorunamentMatchesController::class, 'setPlayingElevenOfTeam2']);

// Get a match scorecard
Route::get('tournament/{tournament}/tournament_matches/{tournament_match}/match-scorecard',[MatchScorecardsController::class, 'index']);
// Create a match scorecard
Route::post('tournament/{tournament}/tournament_matches/{tournament_match}/match-scorecard',[MatchScorecardsController::class, 'store']);
Route::put('tournament/{tournament}/tournament_matches/{tournament_match}/match-scorecard/{match_scorecard}/change-strike-batsman',[MatchScorecardsController::class, 'changeStrikeBatsman']);
Route::put('tournament/{tournament}/tournament_matches/{tournament_match}/match-scorecard/{match_scorecard}/change-non-strike-batsman',[MatchScorecardsController::class, 'changeNonStrikeBatsman']);
Route::put('tournament/{tournament}/tournament_matches/{tournament_match}/match-scorecard/{match_scorecard}/change-bowler',[MatchScorecardsController::class, 'changeBowler']);

// Create a match detail scorecard
Route::post('tournament/{tournament}/tournament_matches/{tournament_match}/match-scorecard/{match_scorecard}/match_detail_scorecards',[ MatchDetailScorecardsController::class, 'store']);
