<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Player;
use App\Models\Team;
use App\Models\Tournament;
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
    public function store(CreatePlayerRequest $request)
    {
        Player::addPlayer($request);
        session()->flash('success','Mail sent successfully ,please check your inbox');
        return redirect()->back();
    }

    public function update(UpdatePlayerRequest $request,Player $player)
    {
        // dd($request);
        $image_path=$request->file('image')->store('players');

        $player->first_name=$request->first_name;
        $player->last_name=$request->last_name;
        $player->dob=$request->dob;
        $player->state=$request->state;
        $player->specialization=$request->specialization;
        $player->balling_hand=$request->balling_hand;
        $player->batting_hand=$request->batting_hand;
        $player->balling_type=$request->balling_type;
        $player->jersey_number=$request->jersey_number;
        $player->fav_playing_spot=$request->fav_playing_spot;
        $player->photo_path=$image_path;
        $player->email_verified_at=Carbon::now();

        $player->expires_at=Carbon::now();

        $player->save();

        session()->flash('success','Details saved successfully');
        return redirect(route('frontend.index'));

    }
    public function validatePlayer()
    {
        // dd(request()->t);
        // dd(Player::isValid(request()->t));
        $player=Player::isValid(request()->t);
        if($player){
            return view('frontend.players.register-player',compact('player'));
        }
        abort(401);
    }
}
