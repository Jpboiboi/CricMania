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
}
