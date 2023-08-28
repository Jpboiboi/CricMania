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
}
