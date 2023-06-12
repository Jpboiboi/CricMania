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
        $playerStat=$player->playerstat;
        return view('frontend.player-stats',compact(['playerStat']));
    }
}
