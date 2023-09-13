<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToArray;

class TorunamentMatchesController extends AjaxController
{
    public function index(Tournament $tournament)
    {
        $teams=$tournament->tournament_matches()->with('team1')->with('team2')->get();
        // dd($tournament->organizer);
        return view('frontend.tournaments.schedule', compact('teams', 'tournament'));

    }
    public function store(Request $request, Tournament $tournament)
    {
        $teams = $tournament->tournament_teams;
        $teamsCount=($teams->count()-1)/2;
        $count=$teams->count()-1;
        $date=$tournament->start_date;

        for($i=1;$i<=$count;$i+=2)
        {

            TournamentMatch::create([
                'team1_id'=>$teams[$i]->id,
                'team2_id'=>$teams[$i+1]->id,
                'tournament_id'=>$tournament->id,
                'match_date'=>$date,
                'no_of_overs'=>$tournament->no_of_overs,
            ]);
            if($tournament->is_single_day === 0){
                $date= Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(1)->format('Y-m-d H:i:s');
            }
        }
        $teamsCount=intval(round($teamsCount/2,0,PHP_ROUND_HALF_DOWN));

        while($teamsCount>0){
            TournamentMatch::create([
                'team1_id'=>$teams[0]->id,
                'team2_id'=>$teams[0]->id,
                'tournament_id'=>$tournament->id,
                'match_date'=>$date,
                'no_of_overs'=>$tournament->no_of_overs
            ]);
            if($tournament->is_single_day === 0){
                $date= Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(1)->format('Y-m-d H:i:s');
            }
            $teamsCount=intval(round($teamsCount/2,0,PHP_ROUND_HALF_DOWN));
        }

        if($count === 6 || $count === 8){
            TournamentMatch::create([
                'team1_id'=>$teams[0]->id,
                'team2_id'=>$teams[0]->id,
                'tournament_id'=>$tournament->id,
                'match_date'=>$date,
                'no_of_overs'=>$tournament->no_of_overs
            ]);
            if($tournament->is_single_day === 0){
                $date= Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(1)->format('Y-m-d H:i:s');
            }

        }
        if($count === 10){
            for($i=0;$i<2;$i++){
                TournamentMatch::create([
                    'team1_id'=>$teams[0]->id,
                    'team2_id'=>$teams[0]->id,
                    'tournament_id'=>$tournament->id,
                    'match_date'=>$date,
                    'no_of_overs'=>$tournament->no_of_overs
                ]);
                if($tournament->is_single_day === 0){
                    $date= Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(1)->format('Y-m-d H:i:s');
                }
            }

        }

        return redirect()->route('frontend.tournaments.schedule',$tournament->id);

    }

    public function update(Request $request, Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        $rules = [
            'toss' => 'required|numeric',
            'elected_to' => 'required|string'
        ];

        $this->validate($request, $rules);

        if(!$this->verifyTournamentMatch($tournament, $tournamentMatch)) {
            return $this->errorResponse("The specified URL cannot be found", 404);
        }

        if($this->verifyTeam($tournamentMatch, $request->toss) && $this->verifyElectionValue($request->elected_to)) {
            if($tournamentMatch->updateToss($request->toss) && $tournamentMatch->updateCurrentlyBatting($request->elected_to)) {
                return $this->showOne($tournamentMatch);
            } else {
                return $this->errorResponse("Toss and Election of batting or bowling can be updated only once", 409);
            }
        }

        return $this->errorResponse("Invalid parameter value", 500);
    }

    public function getTeam1Players(Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        if(request()->has('playing_eleven') && request()['playing_eleven'] === 'true') {
            $team1Players = $tournamentMatch->team1->players()->playing()->with('user')->get();

            return $this->showAll($team1Players);
        }
        $team1Players = $tournamentMatch->team1->players()->with('user')->get();

        return $this->showAll($team1Players);
    }

    public function getTeam2Players(Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        if(request()->has('playing_eleven') && request()['playing_eleven'] === 'true') {
            $team2Players = $tournamentMatch->team2->players()->playing()->with('user')->get();

            return $this->showAll($team2Players);
        }
        $team2Players = $tournamentMatch->team2->players()->with('user')->get();

        return $this->showAll($team2Players);
    }

    public function setPlayingElevenPlayers(Request $request, Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        $rules = [
            'team1_playing_eleven' => 'required|string',
            'team2_playing_eleven' => 'required|string',
            'team1_captain_id' => 'required|string',
            'team2_captain_id' => 'required|string',
        ];

        $this->validate($request, $rules);

        $team1PlayersId = array_map('intval', explode(',', $request->team1_playing_eleven));
        $team2PlayersId = array_map('intval', explode(',', $request->team2_playing_eleven));

        if(sizeof($team1PlayersId) != 11 || sizeof($team2PlayersId) != 11) {
            return $this->errorResponse("11 players must be selected as playing eleven on both the teams", 409);
        }

        if($tournamentMatch->isPlayingElevenSelected()) {
            return $this->errorResponse("Playing eleven can be selected only once", 409);
        }

        $team1Players = $tournamentMatch->team1->players()->pluck('player_id')->toArray();
        if(!in_array($request->team1_captain_id, $team1Players)) {
            return $this->errorResponse("Player must be a part of team to get selected as a Captain", 409);
        }
        foreach ($team1PlayersId as $playerId) {
            if(!in_array($playerId, $team1Players)) {
                return $this->errorResponse("Player must be a part of team to get selected as a playing eleven", 409);
            }
        }

        $team2Players = $tournamentMatch->team2->players()->pluck('player_id')->toArray();
        if(!in_array($request->team2_captain_id, $team2Players)) {
            return $this->errorResponse("Player must be a part of team to get selected as a Captain", 409);
        }
        foreach ($team2PlayersId as $playerId) {
            if(!in_array($playerId, $team2Players)) {
                return $this->errorResponse("Player must be a part of team to get selected as a playing eleven", 409);
            }
        }

        DB::transaction(function () use($request, $tournament, $tournamentMatch, $team1PlayersId, $team2PlayersId){
            foreach ($team1PlayersId as $playerId) {
                $tournamentMatch->team1->players()->updateExistingPivot($playerId, ['is_in_playing_eleven' => true]);
                $tournamentMatch->batsmen()->attach($playerId);
                $tournamentMatch->bowlers()->attach($playerId);

                // TODO : UPDATE no_of_matches played by a player in playerStats as player is selected in playing eleven in a match
                $player = Player::find($playerId);
                $playerStat = $player->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
                $playerStat->no_of_matches++;
                $playerStat->save();
            }
            foreach ($team2PlayersId as $playerId) {
                $tournamentMatch->team2->players()->updateExistingPivot($playerId, ['is_in_playing_eleven' => true]);
                $tournamentMatch->batsmen()->attach($playerId);
                $tournamentMatch->bowlers()->attach($playerId);

                $player = Player::find($playerId);
                $playerStat = $player->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
                $playerStat->no_of_matches++;
                $playerStat->save();
            }
            $tournamentMatch->captain1_id = $request->team1_captain_id;
            $tournamentMatch->captain2_id = $request->team2_captain_id;
            $tournamentMatch->save();
        });

        return $this->showMessage("Players are successfully selected as playing eleven");
    }

    public function setPlayersRoles(Request $request, Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        $rules = [
            'team1_captain_id' => 'required|string',
            'team2_captain_id' => 'required|string',
            'team1_vice_captain_id' => 'required|string',
            'team2_vice_captain_id' => 'required|string',
            'team1_wicket_keeper_id' => 'required|string',
            'team2_wicket_keeper_id' => 'required|string',
        ];
        $this->validate($request, $rules);

        $team1Players = $tournamentMatch->team1->players()->playing()->pluck('player_id')->toArray();
        if(! (in_array($request->team1_captain_id, $team1Players) && in_array($request->team1_vice_captain_id, $team1Players) && in_array($request->team1_wicket_keeper_id, $team1Players))) {
            return $this->errorResponse("Players must be a part of playing eleven players to get selected as a Captain or Vice Captain or Wicket Keeper of team1", 409);
        }

        $team2Players = $tournamentMatch->team2->players()->playing()->pluck('player_id')->toArray();
        if(! (in_array($request->team2_captain_id, $team2Players) && in_array($request->team2_vice_captain_id, $team2Players) && in_array($request->team2_wicket_keeper_id, $team2Players))) {
            return $this->errorResponse("Players must be a part of playing eleven players to get selected as a Captain or Vice Captain or Wicket Keeper of team2", 409);
        }

        $tournamentMatch->captain1_id = $request->team1_captain_id;
        $tournamentMatch->captain2_id = $request->team2_captain_id;
        $tournamentMatch->vice_captain1_id = $request->team1_vice_captain_id;
        $tournamentMatch->vice_captain2_id = $request->team2_vice_captain_id;
        $tournamentMatch->wicket_keeper1_id = $request->team1_wicket_keeper_id;
        $tournamentMatch->wicket_keeper2_id = $request->team2_wicket_keeper_id;
        $tournamentMatch->save();

        return $this->showMessage("Players have been set to their respective roles");
    }

    public function getBattingTeamPlayers(Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        if(request()->has('is_out') && request()['is_out'] == "true") {
            $battingTeamPlayers = $tournamentMatch->currently_batting_team->players()->playing()->out()->with('user')->get();
        } else {
            $battingTeamPlayers = $tournamentMatch->currently_batting_team->players()->playing()->notout()->with('user')->get();
        }
        return $this->showAll($battingTeamPlayers);
    }

    public function getBowlingTeamPlayers(Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        $bowlingTeamPlayers = $tournamentMatch->currently_bowling_team->players()->with('user')->get();

        return $this->showAll($bowlingTeamPlayers);
    }

    public function checkTossAndElectionStatus(Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        if($tournamentMatch->isTossAndElectionUpdated()) {
           return $this->errorResponse("Toss and Election is already done", 409);
        }
        return $this->showMessage("You can update Toss and Election Field");
    }

    public function checkPlayingElevenSelectionStatus(Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        if($tournamentMatch->isPlayingElevenSelected()) {
            return $this->errorResponse("Playing eleven can be selected only once", 409);
        }
        return $this->showMessage("You can select players as playing eleven");
    }

    public function checkMatchScorcardStatus(Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        if(request()->has('inning')) {
            $matchScorecard = $tournamentMatch->isMatchScorecardCreated(request()['inning']);
            if($matchScorecard) {
                return $this->errorResponse(request()['inning'] . "inning is already started", 409);
            }
            return $this->showMessage("You can start ". request()['inning'] . " inning");
        }
        return $this->showMessage("Invalid url", 422);
    }

    private function verifyTournamentMatch(Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        return $tournament->id === $tournamentMatch->tournament_id;
    }

    private function verifyTeam(TournamentMatch $tournamentMatch, int $teamId)
    {
        return $tournamentMatch->team1->id === $teamId || $tournamentMatch->team2->id === $teamId;
    }

    private function verifyElectionValue(string $electedTo)
    {
        return $electedTo === "bat" || $electedTo === "bowl";
    }
}
