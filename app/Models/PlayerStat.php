<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
