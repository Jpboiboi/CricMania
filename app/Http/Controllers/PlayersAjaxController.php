<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTables;

class PlayersAjaxController extends Controller
{
    public function getData(Request $request)
    {
        if ($request->has('search')) {
            $search_parameter = $request->get('search')['value'];
            $order_by = $request->get('order');
            $start = $request->get('start');
            $length = $request->get('length');
            $tournamentId = $request['_tournamentId'];
            $teamId = $request['_teamId'];
            $token = $request['_token'];
            return $this->getTournaments($search_parameter, $order_by, $start, $length, $tournamentId, $teamId, $token);
        }
    }

    private function getTournaments($search_parameter, $order_by, $start, $length, $tournamentId, $teamId, $token)
    {
        $query = Player::query();
        $query->notparticipated($tournamentId);
        $query->search($search_parameter);
        $query->limit_by($start, $length)->get();
        $numberOfTotalRows = Player::all()->count();
        $numberOfFilteredRows = Player::search($search_parameter)->get()->count();
        $query = $query->get();
        return $this->yajraData($query, $numberOfFilteredRows, $numberOfTotalRows, $tournamentId, $teamId, $token);
    }

    private function yajraData(
        Collection $query,
        int $numberOfFilteredRows,
        int $numberOfTotalRows,
        int $tournamentId, int $teamId, $token
    ) {
        return DataTables::of($query)
            ->skipPaging()
            ->addColumn('name', function($player) {
                return $player->first_name . " " . $player->last_name;
            })
            ->addColumn('Specialization', function($player) {
                return $player->specialization;
            })
            ->addColumn('Batting Hand', function($player) {
                return $player->batting_hand;
            })
            ->addColumn('Balling Hand', function($player) {
                return $player->balling_hand;
            })
            ->addColumn('Balling Type', function($player) {
                return $player->balling_type;
            })
            ->addColumn('Fav Playing Spot', function($player) {
                return $player->fav_playing_spot;
            })
            ->addColumn('action', function ($player) use($tournamentId, $teamId, $token) {
                $route = route('add-players.store', [$tournamentId, $teamId]);
                return "
                <form action='$route' method='POST'>
                    <input type='hidden' name='_token' value='$token'>
                    <input type='hidden' value='$player->id' name='player_id'/>
                    <button type='submit' class='btn btn-dark text-warning'><i class='fa fa-plus'></i></button>
                </form>";
            })
            ->rawColumns(['action'])
            ->setFilteredRecords($numberOfFilteredRows)
            ->setTotalRecords($numberOfTotalRows)
            ->make(true);
    }

}
