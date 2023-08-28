<?php

namespace App\Http\Requests;

use App\Models\MatchScorecard;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use Illuminate\Foundation\Http\FormRequest;

class CreateMatchDetailScorecardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $tournamentMatch = $this->route('tournament_match');
        $matchScorecard = $this->route('match_scorecard');

        $bowlerTeam = $tournamentMatch->currently_bowling_team;
        $bowlingTeamPlayers = $bowlerTeam->players()->playing()->pluck('player_id')->toArray();

        // TODO: should use required_with?
        return [
            'runs_by_bat' => 'numeric|digits_between:0,6',
            'run_type' => 'string|in:' . implode(',', MatchScorecard::RUN_TYPE),
            'extra_runs' => 'numeric|digits_between:1,3',
            'ball_type' => 'string|in:' . implode(',', MatchScorecard::BALL_TYPE),
            'wicket_type' => 'string|required_with:out_by,dismissed_batsman|in:' . implode(',', MatchScorecard::WICKET_TYPE),
            'dismissed_batsman' => 'integer|required_with:out_by,wicket_type|in:' . $matchScorecard->strike_batsman_id . ", " . $matchScorecard->non_strike_batsman_id,
            'out_by' => 'integer|required_with:dismissed_batsman,wicket_type|in:' . implode(',', $bowlingTeamPlayers),
        ];
    }
}
