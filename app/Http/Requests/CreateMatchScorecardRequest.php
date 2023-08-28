<?php

namespace App\Http\Requests;

use App\Models\MatchScorecard;
use Illuminate\Foundation\Http\FormRequest;

class CreateMatchScorecardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'strike_batsman_id' => 'required',
            'non_strike_batsman_id' => 'required',
            'bowler_id' => 'required',
            'inning' => 'required|string|in:' . MatchScorecard::FIRST_INNING . ", " . MatchScorecard::SECOND_INNING,
        ];
    }
}
