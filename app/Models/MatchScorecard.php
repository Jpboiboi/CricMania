<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchScorecard extends Model
{
    use HasFactory;

    const RUN_TYPE = ['dot', 'single', 'double', 'triple', 'four', 'five', 'six'];
    const BALL_TYPE = ['wide', 'no_ball', 'bye', 'leg_bye'];
    const WICKET_TYPE = ['bowled', 'catch_out', 'lbw', 'stumping', 'run_out', 'hit_wicket'];
    const INNINGS = ['first', 'second'];
    const FIRST_INNING = 'first';
    const SECOND_INNING = 'second';

    protected $guarded = ['id'];

    public function matchDetailScorecards()
    {
        return $this->hasMany(MatchDetailScorecard::class);
    }

    public function tournamentMatch()
    {
        return $this->belongsTo(TournamentMatch::class, 'tournament_match_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function battingTeam()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function strikeBatsman()
    {
        return $this->belongsTo(Batsman::class, 'strike_batsman_id', 'player_id');
    }

    public function nonStrikeBatsman()
    {
        return $this->belongsTo(Batsman::class, 'non_strike_batsman_id', 'player_id');
    }

    public function bowler()
    {
        return $this->belongsTo(Bowler::class, 'bowler_id', 'player_id');
    }

    public function getLegalDeliveriesCountAttribute()
    {
        return $this->matchDetailScorecards()->legalDeliveries()->count();
    }

    public function isBowlerChangedAfterOver()
    {
        $lastBall = $this->matchDetailScorecards()->latest()->first();
        if($this->bowler_id == $lastBall->ball_by) {
            return false;
        }
        return true;
    }
}
