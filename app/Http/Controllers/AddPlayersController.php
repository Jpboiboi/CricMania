<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlayerRequest;
use App\Models\Player;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;

class AddPlayersController extends Controller
{
    public function index(Tournament $tournament, Team $team) {
        $teamPlayers = $team->players()->get();
        // dd($teamPlayers);
        return view('frontend.players.add-players', compact(['tournament', 'team', 'teamPlayers']));
    }

    public function store(Request $request,Tournament $tournament, Team $team) {
        // dd($request);
        $team->players()->attach($request->player_id, ['tournament_id' => $tournament->id]);
        return redirect()->back();
    }

    public function destroy(Request $request,Tournament $tournament,Team $team,int $teamPlayerId )
    {
        $team->players()->detach($teamPlayerId);
        return redirect()->back();
    }

    public function inviteViaEmail(Tournament $tournament, Team $team) {
        return view('frontend.players.invite-email', compact(['tournament', 'team']));
    }

    public function sendInvite(CreatePlayerRequest $request, Tournament $tournament, Team $team) {
        $player = Player::addPlayer($request);
        $team->players()->attach($player->id, ['tournament_id' => $tournament->id]);
        session()->flash('success','Mail sent successfully to player');
        return redirect()->back();
    }
}
