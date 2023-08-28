<?php

namespace App\Models;

use App\Http\Controllers\MatchDetailScorecardsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Bowler extends Model
{
    use HasFactory;

    public function tournamentMatch()
    {
        return $this->belongsTo(TournamentMatch::class, 'tournament_match_id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function updateBowlerStats(Request $request, MatchScorecard $matchScorecard)
    {

        if($matchScorecard->ball_number%6 === 0) {
            if($this->isMaidenOver($matchScorecard)) {
                $this->no_of_maiden_overs += 1;
            }
        }

        if($request->has('runs_by_bat')) {
            $this->runs_conceeded += $request->runs_by_bat;
        }

        if($request->has('extra_runs') && $request->has('ball_type')) {
            $this->updateDeliveryRunsAndCounts($request->extra_runs, $request->ball_type);
        }

        if($request->has('wicket_type')) {
            if($request->wicket_type != 'run_out') {
                $this->updateWicketStatistics($matchScorecard, $request->wicket_type);
            }
            // if($request->out_by == $matchScorecard->bowler_id) {
            //     $this->updateWicketStatistics($matchScorecard, $request->wicket_type);
            // } else {
            //     $player = Player::find($request->out_by);
            //     $playerBowlingStat = $player->bowler;
            //     $playerBowlingStat->updateWicketStatistics($matchScorecard, $request->wicket_type);
            //     $playerBowlingStat->save();
            // }
        }

        $this->no_of_balls_bowled = $this->no_of_balls_bowled + 1;
        $this->no_of_overs_played = floor($this->no_of_balls_bowled/6) + (($this->no_of_balls_bowled%6)/10);

        $this->save();
    }

    public function updateDeliveryRunsAndCounts(int $extraRuns, string $ballType)
    {
        if ($ballType === 'no_ball') {
            $this->runs_conceeded += $extraRuns;
            $this->no_of_no_balls += 1;
        } else if ($ballType === 'wide') {
            $this->runs_conceeded += $extraRuns;
            $this->no_of_wides += 1;
        } else if ($ballType === 'bye') {
            $this->no_of_byes += 1;
        } else if ($ballType === 'leg_bye') {
            $this->no_of_leg_byes += 1;
        }
    }

    public function updateWicketStatistics(MatchScorecard $matchScorecard, string $wicketType)
    {
        $this->no_of_wickets_taken += 1;

        if($this->no_of_wickets_taken == 4) {
            $tournament = $matchScorecard->tournamentMatch->tournament;
            $bowlerPlayerStat = $this->player->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
            $bowlerPlayerStat->four_wicket_hauls++;
            $bowlerPlayerStat->save();
        }

        if($this->no_of_wickets_taken == 5) {
            $tournament = $matchScorecard->tournamentMatch->tournament;
            $bowlerPlayerStat = $this->player->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
            $bowlerPlayerStat->five_wicket_hauls++;
            $bowlerPlayerStat->four_wicket_hauls--;
            $bowlerPlayerStat->save();
        }

        if ($wicketType === 'lbw') {
            $this->no_of_lbws += 1;
        } else if ($wicketType === 'catch_out') {
            $this->no_of_catch_outs += 1;
        } else if ($wicketType === 'bowled') {
            $this->no_of_bowleds += 1;
        } else if ($wicketType === 'hit_wicket') {
            $this->no_of_hit_wickets += 1;
        } else if ($wicketType === 'stumping') {
            $this->no_of_stumpings += 1;
        } else if ($wicketType === 'run_out') {
            $this->no_of_run_outs += 1;
        }

        if ($this->isHattrick($matchScorecard)) {
            $this->no_of_hattricks += 1;
        }
    }

    private function isMaidenOver(MatchScorecard $matchScorecard) {
        $lastOverBalls = $matchScorecard->matchDetailScorecards()->where('over', $matchScorecard->over)->get();

        foreach($lastOverBalls as $currentBall) {
            if($currentBall->runs_by_bat) {
                return false;
            }
            if($currentBall->extra_runs) {
                return false;
            }
        }
        return true;
    }

    private function isHattrick(MatchScorecard $matchScorecard) {
        $ballsBowled = $matchScorecard->matchDetailScorecards()->where('ball_by', $this->player_id)->latest()->get();
        $wicketCount = 0;
        foreach ($ballsBowled as $ball) {
            if(!($ball->wicket_type || $ball->was_wide || $ball->was_no_ball)) {
                return false;
            }
            if($ball->wicket_type) {
                $wicketCount++;
            }
            if($wicketCount === 3) {
                return true;
            }
        }
        return false;
    }


}
