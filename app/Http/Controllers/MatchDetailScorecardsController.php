<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMatchDetailScorecardRequest;
use App\Models\MatchScorecard;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use Illuminate\Http\Request;

class MatchDetailScorecardsController extends AjaxController
{
    public function store(CreateMatchDetailScorecardRequest $request, Tournament $tournament, TournamentMatch $tournamentMatch, MatchScorecard $matchScorecard)
    {
        /**
         * Data from front-end
         *
         * For Runs
         * runs_by_bat
         * run_type
         *
         * For Extra Runs
         * extra_runs
         * ball_type
         *
         * For Wicket
         * wicket_type
         * dismissed_batsman
         * out_by
         *
         */

        $data = [];
        $ballNumber = $matchScorecard->ball_number;
        $currentTotalRunsScored = $matchScorecard->total_runs_scored;

        $currentRunsByBat = 0;
        if($request->has('runs_by_bat')) {
            $currentRunsByBat = $request->runs_by_bat;
            $currentTotalRunsScored += $request->runs_by_bat;
            $data['was_' . $request->run_type] = true;
        }
        $data['runs_by_bat'] = $currentRunsByBat;

        $currentExtraRuns = 0;
        if($request->has('extra_runs')) {
            $currentExtraRuns = $request->extra_runs;
            $currentTotalRunsScored += $request->extra_runs;
            $data['was_' . $request->ball_type] = true;
            $data['is_legal_delivery'] = false;

        }
        $data['extra_runs'] = $currentExtraRuns;

        $currentWicketsTaken = $matchScorecard->wickets_taken;
        if($request->has('wicket_type')) {
            $currentWicketsTaken++;
            $data['wicket_type'] = $request->wicket_type;
            $data['dismissed_batsman'] = $request->dismissed_batsman;
            $data['out_by'] = $request->out_by;

            if($request->ball_type  === 'no_ball' && $request->wicket_type === 'run_out') {
                $ballNumber++;
            } else if($request->ball_type  === 'wide' && $request->wicket_type === 'stumping') {
                $ballNumber++;
            }

            // Mark player as out in player_team table
            $tournament->players()->updateExistingPivot($request->dismissed_batsman, ['is_out' => true]);
        }
        $data['wickets_taken'] = $currentWicketsTaken;

        if($request->ball_type !== 'no_ball' && $request->ball_type !== 'wide' && $request->ball_type !== 'bye') {
            $ballNumber++;
        }

        $data['bat_by'] = $matchScorecard->strike_batsman_id;
        $data['ball_by'] = $matchScorecard->bowler_id;
        $data['ball_number'] = $ballNumber;
        $data['over'] = ceil($ballNumber/6);
        $data['total_runs_scored'] = $currentTotalRunsScored;
        $data['playing_team'] = $tournamentMatch->currently_batting;

        $striker = $matchScorecard->strikeBatsman()->with('player')->with('player.user')->with(['player.playerstats' => function($playerStats) use($tournament){
            $playerStats->ofTournamentType($tournament->tournament_type_id);
        }])->first();
        $bowler = $matchScorecard->bowler()->with('player')->with('player.user')->with(['player.playerstats' => function($playerStats) use($tournament){
            $playerStats->ofTournamentType($tournament->tournament_type_id);
        }])->first();

        // TODO: Commentary is to be ADDED
        // $strikerName = $striker->player->user->first_name;
        // $bowlerName = $bowler->player->user->first_name;
        // $data['commentary'] = "$strikerName hitted $currentRunsByBat runs to $bowlerName";

        $matchDetailScorecard = $matchScorecard->matchDetailScorecards()->create($data);

        // Updating match scorecard statistics
        $matchScorecard->ball_number = $ballNumber;
        $matchScorecard->over = ceil($ballNumber/6);
        $matchScorecard->runs_by_bat += $currentRunsByBat;
        $matchScorecard->extra_runs += $currentExtraRuns;
        $matchScorecard->total_runs_scored = $currentTotalRunsScored;
        $matchScorecard->wickets_taken = $currentWicketsTaken;
        $matchScorecard->save();

        // Updating Batsman and Bowler Stats of this match
        $striker->updateBatsmanStats($request, $matchScorecard);
        $bowler->updateBowlerStats($request, $matchScorecard);

        // TODO : Updating Batsman and Bowler Overall PLayer Stats
        $striker->updatePlayerBattingStatistics($request, $matchScorecard);
        $bowler->updatePlayerBowlingStatistics($request, $matchScorecard);

        return $this->showOne($matchDetailScorecard, 201);
    }
}
