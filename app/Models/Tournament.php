<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function organizer() {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function teams() {
        return $this->belongsToMany(Team::class, 'player_team');
    }

    public function tournament_matches(){
        return $this->hasMany(TournamentMatch::class);
    }

    public function tournament_teams(){
        return $this->hasMany(Team::class);
    }

    public function players() {
        return $this->belongsToMany(Player::class, 'player_team');
    }

    // SCOPE FUNCTIONS
    public function scopeSearch($query, $searchParam) {
        if(isset($searchParam)) {
            $query->where('name', 'like', "%$searchParam%");
        }
        return $query;
    }

    public function scopeLimit_by($query, $start, $length) {
        if($length != -1) {
            $query->offset($start)->limit($length);
        }
        return $query;
    }


}
