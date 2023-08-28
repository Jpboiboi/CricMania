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
                return $this->errorResponse("Toss and Election of batting or balling can be updated only once", 409);
            }
        }

        return $this->errorResponse("Invalid parameter value", 500);
    }

    public function getTeam1Players(Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        if(request()->has('playing_eleven') && request()['playing_eleven'] === 'true') {
            $team1Players = $tournamentMatch->team1->players()->playing()->get();

            return $this->showAll($team1Players);
        }
        $team1Players = $tournamentMatch->team1->players;

        return $this->showAll($team1Players);
    }

    public function setPlayingElevenOfTeam1(Request $request, Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        $rules = [
            'playing_eleven' => 'required|string'
        ];

        $this->validate($request, $rules);

        $playersId = array_map('intval', explode(',', $request->playing_eleven));

        if(sizeof($playersId) != 11) {
            return $this->errorResponse("11 players must be selected as playing eleven", 409);
        }

        $playingElevenTeam1Players = $tournamentMatch->team1->players()->playing()->count();
        if($playingElevenTeam1Players == 11) {
            return $this->errorResponse("Playing eleven can be selected only once", 409);
        }

        $team1Players = $tournamentMatch->team1->players()->pluck('player_id')->toArray();
        foreach ($playersId as $playerId) {
            if(!in_array($playerId, $team1Players)) {
                return $this->errorResponse("Player must be a part of team to get selected as a playing eleven", 409);
            }
        }

        DB::transaction(function () use($tournament, $tournamentMatch, $playersId){
            foreach ($playersId as $playerId) {
                $tournamentMatch->team1->players()->updateExistingPivot($playerId, ['is_in_playing_eleven' => true]);
                $tournamentMatch->batsmen()->attach($playerId);
                $tournamentMatch->bowlers()->attach($playerId);

                // TODO : UPDATE no_of_matches played by a player in playerStats as player is selected in playing eleven in a match
                $player = Player::find($playerId);
                $playerStat = $player->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
                $playerStat->no_of_matches++;
                $playerStat->save();
            }
        });

        return $this->showAll($tournamentMatch->team1->players);
    }

    public function getTeam2Players(Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        if(request()->has('playing_eleven') && request()['playing_eleven'] === 'true') {
            $team2Players = $tournamentMatch->team2->players()->playing()->get();

            return $this->showAll($team2Players);
        }
        $team2Players = $tournamentMatch->team2->players;

        return $this->showAll($team2Players);
    }

    public function setPlayingElevenOfTeam2(Request $request, Tournament $tournament, TournamentMatch $tournamentMatch)
    {
        $rules = [
            'playing_eleven' => 'required|string'
        ];

        $this->validate($request, $rules);

        $playersId = array_map('intval', explode(',', $request->playing_eleven));

        if(sizeof($playersId) != 11) {
            return $this->errorResponse("11 players must be selected as playing eleven", 409);
        }

        $playingElevenTeam1Players = $tournamentMatch->team2->players()->playing()->count();
        if($playingElevenTeam1Players == 11) {
            return $this->errorResponse("Playing eleven can be selected only once", 409);
        }

        $team2Players = $tournamentMatch->team2->players()->pluck('player_id')->toArray();
        foreach ($playersId as $playerId) {
            if(!in_array($playerId, $team2Players)) {
                return $this->errorResponse("Player must be a part of team to get selected as a playing eleven", 409);
            }
        }

        DB::transaction(function () use($tournament, $tournamentMatch, $playersId){
            foreach ($playersId as $playerId) {
                $tournamentMatch->team2->players()->updateExistingPivot($playerId, ['is_in_playing_eleven' => true]);
                $tournamentMatch->batsmen()->attach($playerId);
                $tournamentMatch->bowlers()->attach($playerId);

                $player = Player::find($playerId);
                $playerStat = $player->playerstats()->ofTournamentType($tournament->tournament_type_id)->first();
                $playerStat->no_of_matches++;
                $playerStat->save();
            }
        });

        return $this->showAll($tournamentMatch->team2->players);
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
        return $electedTo === "bat" || $electedTo === "ball";
    }
}
