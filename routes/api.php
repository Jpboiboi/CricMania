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
Route::put('tournaments/{tournament}/tournament_matches/{tournament_match}/update',[ TorunamentMatchesController::class, 'update']);

// Get all players of team 1 of a match
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/team1-players',[ TorunamentMatchesController::class, 'getTeam1Players']);
// Get all players of team 2 of a match
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/team2-players',[ TorunamentMatchesController::class, 'getTeam2Players']);
// Set playing eleven players of both the teams of a match
Route::put('tournaments/{tournament}/tournament_matches/{tournament_match}/set-playing-eleven-players',[ TorunamentMatchesController::class, 'setPlayingElevenPlayers']);

// Get players of currently batting team of a match
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/batting-team-players',[ TorunamentMatchesController::class, 'getBattingTeamPlayers']);
// Get players of currently bowling team of a match
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/bowling-team-players',[ TorunamentMatchesController::class, 'getBowlingTeamPlayers']);

// Get request to check if toss and election is updated or not
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/check-toss-and-election-status',[ TorunamentMatchesController::class, 'checkTossAndElectionStatus']);
// Get request to check if players are selected as playing eleven or not
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/check-playing-eleven-selection-status',[ TorunamentMatchesController::class, 'checkPlayingElevenSelectionStatus']);
// Get request to check if match scorecard of current inning is created or not
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/check-match-scorcard-status',[ TorunamentMatchesController::class, 'checkMatchScorcardStatus']);

// Get a match scorecard
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards',[MatchScorecardsController::class, 'index']);
// Create a match scorecard
Route::post('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards',[MatchScorecardsController::class, 'store']);
Route::put('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards/{match_scorecard}/change-strike-batsman',[MatchScorecardsController::class, 'changeStrikeBatsman']);
Route::put('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards/{match_scorecard}/change-non-strike-batsman',[MatchScorecardsController::class, 'changeNonStrikeBatsman']);
Route::put('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards/{match_scorecard}/change-bowler',[MatchScorecardsController::class, 'changeBowler']);

// Create a match detail scorecard
Route::post('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards/{match_scorecard}/match_detail_scorecards',[ MatchDetailScorecardsController::class, 'store']);
