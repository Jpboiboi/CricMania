<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMatchDetailScorecardRequest;
use App\Models\Batsman;
use App\Models\Bowler;
use App\Models\MatchDetailScorecard;
use App\Models\MatchScorecard;
use App\Models\Player;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        if($matchScorecard->legal_deliveries_count == $tournamentMatch->no_of_overs*6 || $matchScorecard->wickets_taken == 10) {
            return $this->errorResponse(ucfirst($matchScorecard->inning) . " inning is completed! you cannot proceed with this request", 422);
        }

        if($matchScorecard->ball_number%6 == 0 && !$matchScorecard->isBowlerChangedAfterOver()) {
            return $this->errorResponse("Bowler must be changed after an over", 422);
        }

        if(!$matchScorecard->isBatsmanChangedAfterWicket()) {
            return $this->errorResponse("Batsman must be changed after a wicket", 422);
        }

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

            if($request->ball_type == 'wide') {
                $extraWideRuns = $request->extra_runs - 1;
                if($extraWideRuns == 1 || $extraWideRuns == 3 || $extraWideRuns == 5) {
                    $temp = $matchScorecard->strike_batsman_id;
                    $matchScorecard->strike_batsman_id = $matchScorecard->non_strike_batsman_id;
                    $matchScorecard->non_strike_batsman_id = $temp;
                }
            }

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
                $data['is_legal_delivery'] = true;
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
        if($currentRunsByBat == 1 || $currentRunsByBat == 3 || $currentRunsByBat == 5) {
            $temp = $matchScorecard->strike_batsman_id;
            $matchScorecard->strike_batsman_id = $matchScorecard->non_strike_batsman_id;
            $matchScorecard->non_strike_batsman_id = $temp;
        }
        if($ballNumber%6 == 0) {
            $temp = $matchScorecard->strike_batsman_id;
            $matchScorecard->strike_batsman_id = $matchScorecard->non_strike_batsman_id;
            $matchScorecard->non_strike_batsman_id = $temp;
        }
        $matchScorecard->save();

        // Updating Batsman and Bowler Stats of this match
        $striker->updateBatsmanStats($request, $matchScorecard);
        $bowler->updateBowlerStats($request, $matchScorecard);

        // TODO : Updating Batsman and Bowler Overall PLayer Stats
        $striker->player->playerstats[0]->updatePlayerBattingStatistics($request, $matchScorecard);
        $bowler->player->playerstats[0]->updatePlayerBowlingStatistics($request, $matchScorecard);

        $matchScorecard = $matchScorecard->query()
                            ->where('id', $matchScorecard->id)
                            ->with('tournamentMatch.tournament')
                            ->with('battingTeam')
                            ->with('strikeBatsman.player.user')
                            ->with('nonStrikeBatsman.player.user')
                            ->with('bowler.player.user')
                            ->first();

        return $this->showOne($matchScorecard, 201);
    }

    public function getLastBallDetails(Tournament $tournament, TournamentMatch $tournamentMatch, MatchScorecard $matchScorecard)
    {
        $lastBallDetailScorecard = $matchScorecard->matchDetailScorecards()->latest()->first();
        if(!$lastBallDetailScorecard) {
            return $this->errorResponse("Bowler has not bowled a single ball", 404);
        }

        return $this->showOne($lastBallDetailScorecard);
    }

    public function undoLastBall(Tournament $tournament, TournamentMatch $tournamentMatch, MatchScorecard $matchScorecard, MatchDetailScorecard $matchDetailScorecard)
    {

        DB::transaction(function () use($tournament, $matchScorecard, $matchDetailScorecard){
            $lastBallDetailScorecard = $matchDetailScorecard;
            $secondLastBallDetailScorecard = $matchScorecard->matchDetailScorecards()->latest()->skip(1)->first();

            $striker = Batsman::where('player_id', $lastBallDetailScorecard->bat_by)->with('player')->with('player.user')->with(['player.playerstats' => function($playerStats) use($tournament){
                $playerStats->ofTournamentType($tournament->tournament_type_id);
            }])->first();
            $bowler = Bowler::where('player_id', $lastBallDetailScorecard->ball_by)->with('player')->with('player.user')->with(['player.playerstats' => function($playerStats) use($tournament){
                $playerStats->ofTournamentType($tournament->tournament_type_id);
            }])->first();
            $striker->undoBatsmanStats($matchScorecard, $lastBallDetailScorecard);
            $bowler->undoBowlerStats($matchScorecard, $lastBallDetailScorecard);


            $matchScorecard->runs_by_bat -= $lastBallDetailScorecard->runs_by_bat;
            $matchScorecard->extra_runs -= $lastBallDetailScorecard->extra_runs;

            if($secondLastBallDetailScorecard) {
                $matchScorecard->total_runs_scored = $secondLastBallDetailScorecard->total_runs_scored;
                $matchScorecard->wickets_taken = $secondLastBallDetailScorecard->wickets_taken;
                $matchScorecard->ball_number = $secondLastBallDetailScorecard->ball_number;
                $matchScorecard->over = $secondLastBallDetailScorecard->over;
                $matchScorecard->bowler_id = $secondLastBallDetailScorecard->ball_by;
            } else {
                $matchScorecard->total_runs_scored = 0;
                $matchScorecard->wickets_taken = 0;
                $matchScorecard->ball_number = 0;
                $matchScorecard->over = 0;
            }

            if($lastBallDetailScorecard->runs_by_bat == 1 || $lastBallDetailScorecard->runs_by_bat == 3 || $lastBallDetailScorecard->runs_by_bat == 5) {
                $temp = $matchScorecard->strike_batsman_id;
                $matchScorecard->strike_batsman_id = $matchScorecard->non_strike_batsman_id;
                $matchScorecard->non_strike_batsman_id = $temp;
            }

            if($lastBallDetailScorecard->ball_number%6==0) {
                $temp = $matchScorecard->strike_batsman_id;
                $matchScorecard->strike_batsman_id = $matchScorecard->non_strike_batsman_id;
                $matchScorecard->non_strike_batsman_id = $temp;
            }

            if($lastBallDetailScorecard->dismissed_batsman) {
                if($lastBallDetailScorecard->bat_by == $lastBallDetailScorecard->dismissed_batsman) {
                    // The player which was selected as batsman after the last player was dismissed, his inning has been increased so it should be decreased
                    $newStriker = Player::find($matchScorecard->strike_batsman_id);
                    $newStrikerPlayerStat = $newStriker->playerstats()->where('tournament_type_id', $tournament->tournament_type_id)->first();
                    $newStrikerPlayerStat->no_of_innings--;
                    $newStrikerPlayerStat->save();

                    $matchScorecard->strike_batsman_id = $lastBallDetailScorecard->dismissed_batsman;
                } else {
                    $newNonStriker = Player::find($matchScorecard->non_strike_batsman_id);
                    $newNonStrikerPlayerStat = $newNonStriker->playerstats()->where('tournament_type_id', $tournament->tournament_type_id)->first();
                    $newNonStrikerPlayerStat->no_of_innings--;
                    $newNonStrikerPlayerStat->save();

                    $matchScorecard->non_strike_batsman_id = $lastBallDetailScorecard->dismissed_batsman;
                }
                $tournament->players()->updateExistingPivot($lastBallDetailScorecard->dismissed_batsman, ['is_out' => false]);
            }
            $matchScorecard->save();

            $matchDetailScorecard->delete();
        });

        return $this->showMessage("Undo Successfull");
    }
}
