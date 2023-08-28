<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PlayerStat extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function player()
    {
       return $this->belongsTo(Player::class);
    }

    public function tournament_type() {
        return $this->belongsTo(TournamentType::class, 'tournament_type_id');
    }

    public function getPlayerOutAttribute()
    {
        $outs=$this->no_of_lbw + $this->no_of_stumpings + $this->no_of_catch_outs + $this->no_of_run_outs + $this->no_of_bowled;
        return $outs;
    }
    public function getPlayerAvgAttribute()
    {
        if($this->player_out > 0){
            return round($this->no_of_innings/$this->player_out,2);

        }
        return $this->no_of_innings;
    }
    public function getPlayerSrAttribute()
    {
        if($this->no_of_balls_faced>0){
           return round(($this->no_of_runs_scored / $this->no_of_balls_faced) * 100 ,2);
        }
        return 0;

    }
    public function getBallingAvgAttribute()
    {
        if($this->no_of_wickets_taken > 0){
            return round($this->no_of_runs_conceeded / $this->no_of_wickets_taken,2);
        }
        return $this->no_of_runs_conceeded;
    }
    public function getBallingEcoAttribute()
    {
        if($this->no_of_balls_bowled > 0){
            return round($this->no_of_runs_conceeded / ($this->no_of_balls_bowled)*6,2);
        }
        return 0;

    }
    public function  getBallingSrAttribute()
    {
        if($this->no_of_wickets_taken > 0){
            return round(($this->no_of_balls_bowled / $this->no_of_wickets_taken )*100,2);
        }
        return ($this->no_of_balls_bowled*100);

    }

    public function updatePlayerBattingStatistics(Request $request, MatchScorecard $matchScorecard)
    {
        if($request->has('runs_by_bat')) {
            $this->updateRunsAndCounts($request->runs_by_bat);
        }

        if($request->has('wicket_type')) {
            if($request->dismissed_batsman == $matchScorecard->strike_batsman_id) {
                $this->no_of_dismissals++;
            } else if($request->dismissed_batsman == $matchScorecard->non_strike_batsman_id) {
                $tournament = $matchScorecard->tournamentMatch->tournament;
                $nonStriker = $matchScorecard->nonStrikeBatsman->player->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
                $nonStriker->no_of_dismissals++;
                $nonStriker->save();
            }
        }

        $this->no_of_balls_faced++;

        $this->save();
    }

    public function updateRunsAndCounts($runsByBat)
    {
        if ($runsByBat == 1) {
            $this->no_of_runs_scored += 1;
            $this->no_of_singles += 1;
        } else if ($runsByBat == 2) {
            $this->no_of_runs_scored += 2;
            $this->no_of_doubles += 1;
        } else if ($runsByBat == 3) {
            $this->no_of_runs_scored += 3;
            $this->no_of_triples += 1;
        } else if ($runsByBat == 4) {
            $this->no_of_runs_scored += 4;
            $this->no_of_fours += 1;
        } else if ($runsByBat == 5) {
            $this->no_of_runs_scored += 5;
            $this->no_of_fives += 1;
        } else if ($runsByBat == 6) {
            $this->no_of_runs_scored += 6;
            $this->no_of_sixes += 1;
        } else {
            $this->no_of_runs_scored += 0;
            $this->no_of_dots += 1;
        }

    }

    public function updatePlayerBowlingStatistics(Request $request, MatchScorecard $matchScorecard)
    {

        if($matchScorecard->ball_number%6 === 0) {
            if($this->isMaidenOver($matchScorecard)) {
                $this->no_of_maidens += 1;
            }
        }

        if($request->has('runs_by_bat')) {
            $this->no_of_runs_conceeded += $request->runs_by_bat;
        }

        if($request->has('extra_runs')) {
            $this->no_of_runs_conceeded += $request->extra_runs;
        }

        if($request->has('ball_type')) {
            $this->updateDeliveryCounts($request->ball_type);
        }

        if($request->has('wicket_type')) {
            if($request->wicket_type != 'run_out') {
                $this->updateWicketStatistics($matchScorecard, $request->wicket_type);
            }
            // if($request->out_by == $matchScorecard->bowler_id) {
            //     $this->updateWicketStatistics($matchScorecard, $request->wicket_type);
            // } else {
            //     $player = Player::find($request->out_by);
            //     $tournament = $matchScorecard->tournamentMatch->tournament;
            //     $playerBowlingStat = $player->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
            //     $playerBowlingStat->updateWicketStatistics($matchScorecard, $request->wicket_type);
            //     $playerBowlingStat->save();
            // }
        }

        $this->no_of_balls_bowled = $this->no_of_balls_bowled + 1;

        $this->save();
    }

    public function updateDeliveryCounts($ballType)
    {
        if ($ballType === 'no_ball') {
            $this->no_balls += 1;
        } else if ($ballType === 'wide') {
            $this->wides += 1;
        } else if ($ballType === 'bye') {
            $this->byes += 1;
        }
    }

    public function updateWicketStatistics(MatchScorecard $matchScorecard, string $wicketType)
    {
        $this->no_of_wickets_taken += 1;

        if ($wicketType === 'lbw') {
            $this->no_of_lbws += 1;
        } else if ($wicketType === 'catch_out') {
            $this->no_of_catches += 1;
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
            $this->hattricks += 1;
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

    // SCOPE FUNCTIONS
    public function scopeOfTournamentType($query, $tournamentTypeId)
    {
        return $query->where('tournament_type_id', $tournamentTypeId);
    }

}
