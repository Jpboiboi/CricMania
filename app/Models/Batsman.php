<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Batsman extends Model
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

    public function updateBatsmanStats(Request $request, MatchScorecard $matchScorecard)
    {
        if($request->has('runs_by_bat')) {
            $this->updateRunsAndCounts($request->runs_by_bat);
        }

        if($this->runs_scored >= 50 && !$this->has_scored_fifty) {
            $tournament = $matchScorecard->tournamentMatch->tournament;
            $batsmanPlayerStat = $this->player->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
            $batsmanPlayerStat->no_of_fifties++;
            $batsmanPlayerStat->save();

            $this->has_scored_fifty = true;
        }

        if($this->runs_scored >= 100 && !$this->has_scored_hundred) {
            $tournament = $matchScorecard->tournamentMatch->tournament;
            $batsmanPlayerStat = $this->player->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
            $batsmanPlayerStat->no_of_hundreds++;
            $batsmanPlayerStat->no_of_fifties--;
            $batsmanPlayerStat->save();

            $this->has_scored_hundred = true;
        }

        if($request->has('wicket_type')) {
            if($request->dismissed_batsman == $matchScorecard->strike_batsman_id) {
                $this->updateWicketStatistics($request->out_by, $request->wicket_type);
            } else if($request->dismissed_batsman == $matchScorecard->non_strike_batsman_id) {
                $nonStriker = $matchScorecard->nonStrikeBatsman;
                $nonStriker->updateWicketStatistics($request->out_by, $request->wicket_type);
                $nonStriker->save();
            }
        }

        if($request->ball_type != 'wide') {
            $this->no_of_balls_faced++;
        }

        $this->save();
    }

    public function updateRunsAndCounts($runsByBat)
    {
        if ($runsByBat == 1) {
            $this->runs_scored += 1;
            $this->no_of_singles += 1;
        } else if ($runsByBat == 2) {
            $this->runs_scored += 2;
            $this->no_of_doubles += 1;
        } else if ($runsByBat == 3) {
            $this->runs_scored += 3;
            $this->no_of_triples += 1;
        } else if ($runsByBat == 4) {
            $this->runs_scored += 4;
            $this->no_of_fours += 1;
        } else if ($runsByBat == 5) {
            $this->runs_scored += 5;
            $this->no_of_fives += 1;
        } else if ($runsByBat == 6) {
            $this->runs_scored += 6;
            $this->no_of_sixes += 1;
        } else {
            $this->runs_scored += 0;
            $this->no_of_dots += 1;
        }
    }

    public function updateWicketStatistics(int $outBy, string $wicketType)
    {
        $this->how_out = $wicketType;
        $this->out_by = $outBy;
    }

    public function undoBatsmanStats(MatchScorecard $matchScorecard, MatchDetailScorecard $lastBallDetailScorecard)
    {
        $this->runs_scored -= $lastBallDetailScorecard->runs_by_bat;
        if ($lastBallDetailScorecard->was_single) {
            $this->no_of_singles -= 1;
        } else if ($lastBallDetailScorecard->was_double) {
            $this->no_of_doubles -= 1;
        } else if ($lastBallDetailScorecard->was_triple) {
            $this->no_of_triples -= 1;
        } else if ($lastBallDetailScorecard->was_four) {
            $this->no_of_fours -= 1;
        } else if ($lastBallDetailScorecard->was_five) {
            $this->no_of_fives -= 1;
        } else if ($lastBallDetailScorecard->was_six) {
            $this->no_of_sixes -= 1;
        } else if ($lastBallDetailScorecard->was_dot) {
            $this->no_of_dots -= 1;
        }

        if($this->runs_scored < 50 && $this->has_scored_fifty) {
            $tournament = $matchScorecard->tournamentMatch->tournament;
            $batsmanPlayerStat = $this->player->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
            $batsmanPlayerStat->no_of_fifties++;
            $batsmanPlayerStat->save();

            $this->has_scored_fifty = false;
        }

        if($this->runs_scored < 100 && $this->has_scored_hundred) {
            $tournament = $matchScorecard->tournamentMatch->tournament;
            $batsmanPlayerStat = $this->player->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
            $batsmanPlayerStat->no_of_hundreds--;
            $batsmanPlayerStat->no_of_fifties++;
            $batsmanPlayerStat->save();

            $this->has_scored_hundred = false;
        }

        if($lastBallDetailScorecard->wicket_type) {
            if($lastBallDetailScorecard->bat_by == $lastBallDetailScorecard->dismissed_batsman) {
                $this->how_out = null;
                $this->out_by = null;
            } else {
                $nonStriker = Batsman::where('player_id', $lastBallDetailScorecard->dismissed_batsman)->first();
                $nonStriker->how_out = null;
                $nonStriker->out_by = null;
                $nonStriker->save();
            }
        }

        if(!$lastBallDetailScorecard->was_wide) {
            $this->no_of_balls_faced--;
        }

        $this->save();
    }
}
