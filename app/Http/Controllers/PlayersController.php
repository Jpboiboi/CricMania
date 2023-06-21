<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    public function index()
    {
       $players= Player::latest('updated_at')->paginate(5);
       return view('frontend.players.players-details',compact('players'));

    }
}
