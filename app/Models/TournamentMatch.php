<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentMatch extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    const LIVE="live";

    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }

    public function getIsLiveAttribute(): bool
    {
        return $this->match_date <= now();
    }

    public function matchScorecards()
    {
        return $this->hasMany(MatchScorecard::class);
    }

    public function batsmen()
    {
        return $this->belongsToMany(Player::class, 'batsmen');
    }

    public function bowlers()
    {
        return $this->belongsToMany(Player::class, 'bowlers');
    }

    public function getCurrentlyBattingTeamAttribute()
    {
        return $this->currently_batting === $this->team1->id ? $this->team1 : $this->team2;
    }

    public function getCurrentlyBowlingTeamAttribute()
    {
        return $this->currently_batting === $this->team1->id ? $this->team2 : $this->team1;
    }

    // AJAX FUNCTIONS

    // Updating toss of a match
    public function updateToss(int $toss)
    {
        if($this->toss == null) {
            $this->toss = $toss;
            $this->save();

            return 1;
        }
        return 0;
    }

    // Updating currently_batting team of a match
    public function updateCurrentlyBatting(string $electedTo)
    {
        if($this->currently_batting == null) {
            if($electedTo === 'bat') {
                $this->currently_batting = $this->toss;
            } else if($electedTo === 'bowl'){
                $this->currently_batting = $this->toss === $this->team1->id ? $this->team2->id : $this->team1->id;
            }
            $this->save();

            return 1;
        }
        return 0;
    }

    public function isTossAndElectionUpdated():bool
    {
        return $this->toss && $this->currently_batting;
    }

    public function isPlayingElevenSelected():bool
    {
        $playingElevenTeam1Players = $this->team1->players()->playing()->count();
        $playingElevenTeam2Players = $this->team2->players()->playing()->count();

        return $playingElevenTeam1Players == 11 && $playingElevenTeam2Players == 11;
    }

    public function isMatchScorecardCreated(string $inning):MatchScorecard | null
    {
        return $this->matchScorecards()->where('inning', $inning)->first();
    }
}
