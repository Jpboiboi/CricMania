<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlayerRequest;
use App\Models\Player;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AddPlayersController extends Controller
{
    public function index(Tournament $tournament, Team $team)
    {
        if($team->tournament_id !== $tournament->id) {
            abort(404);
        }
        if (request()->t) {
            $user = User::isValid(request()->t);
            if ($user) {
                if (auth()->user()->id === $user->id) {
                    $teamPlayers = $team->players()->get();
                    return view('frontend.players.add-players', compact(['tournament', 'team', 'teamPlayers']));
                }
            }
        }else if(auth()->user()->role==='admin'){
            $teamPlayers = $team->players()->get();
            return view('frontend.players.add-players', compact(['tournament', 'team', 'teamPlayers']));
        }
        abort(401);
    }

    public function store(Request $request, Tournament $tournament, Team $team)
    {
        $team->players()->attach($request->player_id, ['tournament_id' => $tournament->id]);

        return redirect()->back();
    }

    public function destroy(Request $request, Tournament $tournament, Team $team, int $teamPlayerId)
    {
        $team->players()->detach($teamPlayerId);
        return redirect()->back();
    }

    public function inviteViaEmail(Tournament $tournament, Team $team)
    {
        return view('frontend.players.invite-email', compact(['tournament', 'team']));
    }

    public function sendInvite(CreatePlayerRequest $request, Tournament $tournament, Team $team)
    {
        $user = User::addUser($request);
        $player = Player::create([
            'user_id' => $user->id
        ]);
        $team->players()->attach($player->id, ['tournament_id' => $tournament->id]);
        session()->flash('success', 'Mail sent successfully to player');
        return redirect(route('add-players.index', [$tournament->id, $team->id]));
    }

    public function update(Request $request, User $user)
    {
        $image_path = $request->file('image')->store('players');
        $password = Hash::make($request->newPassword);
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'photo_path' => $image_path,
            'password' => $password,
            'email_verified_at' => Carbon::now()
        ]);

        Player::updatePlayer($request, $user);

        session()->flash('success', 'Details saved successfully');
        return redirect(route('frontend.index'));
    }

    public function storeCaptain(Request $request, Tournament $tournament, Team $team, User $user)
    {
        $image_path = $request->file('image')->store('players');
        $password = Hash::make($request->password);
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'photo_path' => $image_path,
            'password' => $password,
            'email_verified_at' => Carbon::now()
        ]);

        Player::addPlayer($request, $user);

        $user->addCaptain($tournament->id, $team->id, $user->player->id);
        session()->flash('success', 'Your details saved successfully,please check your inbox to add further team players');
        return redirect(route('frontend.index'));
    }

    public function validatePlayer()
    {
        $user = User::isValid(request()->t);
        if ($user) {
            return view('frontend.players.invite-user', compact('user'));
        }
        abort(401);
    }

    public function validateCaptain(Tournament $tournament, Team $team)
    {
        $user = User::isValid(request()->t);
        if ($user) {
            return view('frontend.players.invite-captain', compact(['user', 'tournament', 'team']));
        }
        abort(401);
    }
}
