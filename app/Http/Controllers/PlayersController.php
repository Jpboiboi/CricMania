<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Player;
use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use App\Notifications\InvitePlayer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PlayersController extends Controller
{
    public function index()
    {
        return view('frontend.players.players-details');
    }

    public function edit(Player $player)
    {
        return view('frontend.players.edit-player',compact('player'));
    }

    public function update(Request $request,Player $player)
    {
        $data=$request->except('_token','_method');
        $player->update($data);
        $player->save();
        session()->flash('success', 'updated successfully');
        return redirect()->back();
    }
}
