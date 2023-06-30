<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerStat;
use App\Models\User;
use Illuminate\Http\Request;

class PlayerStatsController extends Controller
{
    public function show(Player $player)
    {
        $user = $player->user()->first();
        $playerStats=$player->playerstats;
        return view('frontend.players.player-stats',compact(['playerStats', 'user']));
    }
}
