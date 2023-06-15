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
}
