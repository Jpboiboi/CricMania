<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentMatch extends Model
{
    protected $guarded=['id'];
    use HasFactory;
    const LIVE="live";
    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }
    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }
    public function getIsLiveAttribute(): bool
    {
        return $this->match_date <= now();
    }
}
