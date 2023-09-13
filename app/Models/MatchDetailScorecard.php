<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchDetailScorecard extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function matchScorecard()
    {
        return $this->belongsTo(MatchScorecard::class, 'match_scorecard_id');
    }

    // SCOPE FUNCTIONS
    public function scopeCurrentOver($query, $overNumber)
    {
        return $query->where('over', $overNumber);
    }

    public function scopeLegalDeliveries($query)
    {
        return $query->where('is_legal_delivery', true);
    }
}
