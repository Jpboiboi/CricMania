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
            $token = $request['_token'];
            return $this->getPlayers($search_parameter, $order_by, $start, $length, $token);
        }
    }

    private function getPlayers($search_parameter, $order_by, $start, $length,  $token)
    {
        $query = Player::query();
        $query->notverified();
        $query->search($search_parameter);
        $query->limit_by($start, $length)->get();
        $numberOfTotalRows = Player::all()->count();
        $numberOfFilteredRows = Player::search($search_parameter)->get()->count();
        $query = $query->get();
        return $this->yajraData($query, $numberOfFilteredRows, $numberOfTotalRows, $token);
    }

    private function yajraData(
        Collection $query,
        int $numberOfFilteredRows,
        int $numberOfTotalRows,
        $token
    ) {
        return DataTables::of($query)
            ->skipPaging()
            ->addColumn('Profile', function($player) {
                $hasProfile=$player->photo_path;
                if($hasProfile){
                    $imagePath=asset('storage/'.$player->photo_path);
                    return '<img src="'.$imagePath.'" width="100px" class="rounded-circle bg-light border border-dark border-2" />';
                }else{
                   $defaultImg=asset('assets/img/player-avatar.png');
                   return  '<img src="'.$defaultImg.'" width="100px" class="rounded-circle bg-light border border-dark border-2" />';
                }

            })
            ->addColumn('name', function($player) {
                return $player->first_name . " " . $player->last_name;
            })
            ->addColumn('Date of birth', function($player) {
                return $player->dob;
            })
            ->addColumn('State', function($player) {
                return $player->state;
            })
            ->addColumn('Specialization', function($player) {
                return $player->specialization;
            })
            ->addColumn('Jersey no', function($player) {
                return $player->jersey_number;
            })

            ->addColumn('action', function ($player){
                $route = route('frontend.players.player-stats',$player->slug);
                return "<a href='$route' class='btn btn-outline-info me-1'><i class='fa fa-eye'></i></a> ";

            })
            ->rawColumns(['Profile','action'])
            ->setFilteredRecords($numberOfFilteredRows)
            ->setTotalRecords($numberOfTotalRows)
            ->make(true);
    }

}
