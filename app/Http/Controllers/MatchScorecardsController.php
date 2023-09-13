<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMatchScorecardRequest;
use App\Models\MatchScorecard;
use App\Models\Player;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MatchScorecardsController extends AjaxController
{
    public function index(Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        $matchScorecard = $tournamentMatch->matchScorecards()->where('inning', request()->inning)
                    ->with('tournamentMatch.tournament')
                    ->with('battingTeam')
                    ->with('strikeBatsman.player.user')
                    ->with('nonStrikeBatsman.player.user')
                    ->with('bowler.player.user')
                    ->first();

        if($matchScorecard) {
            return $this->showOne($matchScorecard);
        }
        return $this->errorResponse(ucfirst(request()->inning) . " inning is not started yet", 404);
    }

    public function store(CreateMatchScorecardRequest $request, Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        if($request->inning == 'second') {
            if(!$tournamentMatch->isFirstInningCompleted()) {
                return $this->errorResponse("First inning is still going on! You cannot start second inning", 409);
            }
        }

        if(!$this->verifyBatsman($tournamentMatch, $request->strike_batsman_id)) {
            return $this->errorResponse("Strike Batsman can only selected from currently batting team!!", 409);
        }

        if(!$this->verifyBatsman($tournamentMatch, $request->non_strike_batsman_id)) {
            return $this->errorResponse("Non Strike Batsman can only selected from currently batting team!!", 409);
        }

        if(!$this->verifyBowler($tournamentMatch, $request->bowler_id)) {
            return $this->errorResponse("Bowler can only selected from currently bowling team!!", 409);
        }

        if(!$tournamentMatch->isMatchScorecardCreated($request->inning)) {
            $matchScorecard = $tournamentMatch->matchScorecards()->firstOrCreate([
                'team_id' => $tournamentMatch->currently_batting,
                'strike_batsman_id' => $request->strike_batsman_id,
                'non_strike_batsman_id' => $request->non_strike_batsman_id,
                'bowler_id' => $request->bowler_id,
                'inning' => $request->inning
            ]);

            // TODO : UPDATE no_of_innings played by a player in playerStats as player is selected as striker or non strike in a match
            $striker = Player::find($matchScorecard->strike_batsman_id);
            $strikerPlayerStat = $striker->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
            $strikerPlayerStat->no_of_innings++;
            $strikerPlayerStat->save();

            $nonStriker = Player::find($matchScorecard->non_strike_batsman_id);
            $nonStrikerPlayerStat = $nonStriker->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
            $nonStrikerPlayerStat->no_of_innings++;
            $nonStrikerPlayerStat->save();

            // Updating the match state as the first inning starts
            if($request->inning == 'first') {
                $tournamentMatch->match_state = TournamentMatch::MATCH_STARTED;
                $tournamentMatch->save();
            }

            return $this->showOne($matchScorecard, 201);
        }
        return $this->errorResponse("OOPs!! Scorecard is already created!!!", 500);

    }

    public function changeStrikeBatsman(Request $request, Tournament $tournament, TournamentMatch $tournamentMatch, MatchScorecard $matchScorecard)
    {
        $rules = [
            'strike_batsman_id' => 'required|notIn:' . $matchScorecard->strike_batsman_id . "," . $matchScorecard->non_strike_batsman_id,
        ];
        $this->validate($request, $rules);

        if(!$this->verifyBatsman($tournamentMatch, $request->strike_batsman_id)) {
            return $this->errorResponse("Strike Batsman can only selected from currently batting team!!", 409);
        }

        $battingTeam = $tournamentMatch->currently_batting_team;
        $nextStriker = $battingTeam->players()->playing()->where('player_id', $request->strike_batsman_id)->notout()->first();
        if($nextStriker) {
            $matchScorecard->strike_batsman_id = $nextStriker->id;
            $matchScorecard->save();

            $striker = Player::find($matchScorecard->strike_batsman_id);
            $strikerPlayerStat = $striker->playerstats()->where('tournament_type_id', $tournament->tournament_type_id)->first();
            $strikerPlayerStat->no_of_innings++;
            $strikerPlayerStat->save();

            return $this->showOne($nextStriker);
        }
        return $this->errorResponse("The selected strike batsman is out!", 422);

    }

    public function changeNonStrikeBatsman(Request $request, Tournament $tournament, TournamentMatch $tournamentMatch, MatchScorecard $matchScorecard)
    {
        $rules = [
            'non_strike_batsman_id' => 'required|notIn:' . $matchScorecard->strike_batsman_id . "," . $matchScorecard->non_strike_batsman_id,
        ];
        $this->validate($request, $rules);

        if(!$this->verifyBatsman($tournamentMatch, $request->non_strike_batsman_id)) {
            return $this->errorResponse("Non Strike Batsman can only selected from currently batting team!!", 409);
        }

        $battingTeam = $tournamentMatch->currently_batting_team;
        $nextNonStriker = $battingTeam->players()->playing()->where('player_id', $request->non_strike_batsman_id)->notout()->first();
        if($nextNonStriker) {
            $matchScorecard->non_strike_batsman_id = $nextNonStriker->id;
            $matchScorecard->save();

            $nonStriker = Player::find($matchScorecard->non_strike_batsman_id);
            $nonStrikerPlayerStat = $nonStriker->playerstats()->where('tournament_type_id', $tournament->tournament_type_id)->first();
            $nonStrikerPlayerStat->no_of_innings++;
            $nonStrikerPlayerStat->save();

            return $this->showOne($nextNonStriker);
        }
        return $this->errorResponse("The selected non strike batsman is out!", 422);

    }

    public function changeBowler(Request $request, Tournament $tournament, TournamentMatch $tournamentMatch, MatchScorecard $matchScorecard)
    {
        $rules = [
            'bowler_id' => 'required|notIn:' . $matchScorecard->bowler_id,
        ];
        $this->validate($request, $rules);

        if(!$this->verifyBowler($tournamentMatch, $request->bowler_id)) {
            return $this->errorResponse("Bowler can only selected from currently bowling team!!", 409);
        }

        $bowlingTeam = $tournamentMatch->currently_bowling_team;
        $nextBowler = $bowlingTeam->players()->playing()->where('player_id', $request->bowler_id)->first();

        if($nextBowler) {
            $matchScorecard->bowler_id = $nextBowler->id;

            // Shifting sides after completing an over
            $temp = $matchScorecard->strike_batsman_id;
            $matchScorecard->strike_batsman_id = $matchScorecard->non_strike_batsman_id;
            $matchScorecard->non_strike_batsman_id = $temp;
            $matchScorecard->save();

            return $this->showOne($nextBowler);
        }
        return $this->errorResponse("Some Error ocurred", 500);

    }

    public function getCurrentOverDetails(Tournament $tournament, TournamentMatch $tournamentMatch, MatchScorecard $matchScorecard)
    {
        $data = $matchScorecard->matchDetailScorecards()->currentOver($matchScorecard->over)->get();

        return $this->showAll($data);
    }

    public function markInningAsCompleted(Request $request, Tournament $tournament, TournamentMatch $tournamentMatch, MatchScorecard $matchScorecard)
    {
        $matchScorecard->is_completed = Carbon::now();
        $matchScorecard->save();

        return $this->showOne($matchScorecard);
    }

    private function verifyBatsman(TournamentMatch $tournamentMatch, int $batsmanId):bool
    {
        $battingTeam = $tournamentMatch->currently_batting_team;
        $battingTeamPlayers = $battingTeam->players()->playing()->pluck('player_id')->toArray();
        if(!( in_array($batsmanId, $battingTeamPlayers))) {
            return false;
        }
        return true;
    }

    private function verifyBowler(TournamentMatch $tournamentMatch, int $bowlerId):bool
    {
        $bowlerTeam = $tournamentMatch->currently_bowling_team;
        $bowlingTeamPlayers = $bowlerTeam->players()->playing()->pluck('player_id')->toArray();
        if(!in_array($bowlerId, $bowlingTeamPlayers)) {
            return false;
        }
        return true;
    }
}
