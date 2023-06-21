<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function players() {
        return $this->belongsToMany(Player::class);
    }

    public function tournaments() {
        return $this->belongsToMany(Tournament::class);
    }

    // public function notInTeam() {
    //     return $this->belongsToMany(Player::class, 'team_players');
    //     // ->join('team_players', 'players.id', '!=', 'team_players.player_id')
    // }

    public function getImagePathAttribute() {
        return '/storage/'.$this->attributes['image_path'];
    }


    public function tournament(){
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }
}
