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
Route::put('tournaments/{tournament}/tournament_matches/{tournament_match}/update',[TorunamentMatchesController::class, 'update']);

// Get all players of team 1 of a match
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/team1-players',[TorunamentMatchesController::class, 'getTeam1Players']);
// Get all players of team 2 of a match
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/team2-players',[TorunamentMatchesController::class, 'getTeam2Players']);
// Set playing eleven players of both the teams of a match
Route::put('tournaments/{tournament}/tournament_matches/{tournament_match}/set-playing-eleven-players',[TorunamentMatchesController::class, 'setPlayingElevenPlayers']);
// Set players roles of both the teams in a match
Route::put('tournaments/{tournament}/tournament_matches/{tournament_match}/set-players-roles',[TorunamentMatchesController::class, 'setPlayersRoles']);

// Get players of currently batting team of a match
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/batting-team-players',[TorunamentMatchesController::class, 'getBattingTeamPlayers']);
// Get players of currently bowling team of a match
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/bowling-team-players',[TorunamentMatchesController::class, 'getBowlingTeamPlayers']);

// Get request to check if toss and election is updated or not
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/check-toss-and-election-status',[TorunamentMatchesController::class, 'checkTossAndElectionStatus']);
// Get request to check if players are selected as playing eleven or not
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/check-playing-eleven-selection-status',[TorunamentMatchesController::class, 'checkPlayingElevenSelectionStatus']);
// Get request to check if Captain, Vice Captain and Wicket Keeper of both the teams are selected or not
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/check-players-roles-selection-status',[TorunamentMatchesController::class, 'checkPlayersRolesSelectionStatus']);
// Get request to check if match scorecard of current inning is created or not
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/check-match-scorcard-status',[TorunamentMatchesController::class, 'checkMatchScorcardStatus']);

// Get a match scorecard
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards',[MatchScorecardsController::class, 'index']);
// Create a match scorecard
Route::post('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards',[MatchScorecardsController::class, 'store']);
// To change strike batsman
Route::put('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards/{match_scorecard}/change-strike-batsman',[MatchScorecardsController::class, 'changeStrikeBatsman']);
// To change non strike batsman
Route::put('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards/{match_scorecard}/change-non-strike-batsman',[MatchScorecardsController::class, 'changeNonStrikeBatsman']);
// To change bowler
Route::put('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards/{match_scorecard}/change-bowler',[MatchScorecardsController::class, 'changeBowler']);

// To get the scorecard details of current over
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards/{match_scorecard}/current-over-details',[MatchScorecardsController::class, 'getCurrentOverDetails']);
// To mark the scorecard as completed
Route::put('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards/{match_scorecard}/mark-inning-as-completed',[MatchScorecardsController::class, 'markInningAsCompleted']);


// Create a match detail scorecard
Route::post('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards/{match_scorecard}/match_detail_scorecards',[MatchDetailScorecardsController::class, 'store']);
// To get last ball details
Route::get('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards/{match_scorecard}/match_detail_scorecards/last-ball-details',[MatchDetailScorecardsController::class, 'getLastBallDetails']);
// To undo last ball
Route::delete('tournaments/{tournament}/tournament_matches/{tournament_match}/match_scorecards/{match_scorecard}/match_detail_scorecards/{match_detail_scorecard}/undo-last-ball',[MatchDetailScorecardsController::class, 'undoLastBall']);
