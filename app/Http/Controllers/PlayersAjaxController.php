<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
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
        $query = User::where('role', 'player');
        $query->notverified();
        $query->search($search_parameter);
        $query->limit_by($start, $length)->get();
        $numberOfTotalRows = User::all()->count();
        $numberOfFilteredRows = User::search($search_parameter)->get()->count();
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
            ->addColumn('Profile', function($user) {
                 $hasProfile=$user->photo_path;
                 if($hasProfile){
                     $imagePath=asset('storage/'.$user->photo_path);
                     return '<img src="'.$imagePath.'" width="100px" class="rounded-circle bg-light border border-dark border-2" />';
                 }
                 else{
                    $defaultImg=asset('assets/img/player-avatar.png');
                    return  '<img src="'.$defaultImg.'" width="100px" class="rounded-circle bg-light border border-dark border-2" />';
                 }
                $defaultImg=asset('assets/img/player-avatar.png');
                return  '<img src="'.$defaultImg.'" width="100px" class="rounded-circle bg-light border border-dark border-2" />';
            })
            ->addColumn('name', function($user) {
                return $user->first_name . " " . $user->last_name;
            })
            ->addColumn('Date of birth', function($user) {
                return $user->player->dob;
            })
            ->addColumn('State', function($user) {
                return $user->player->state;
            })
            ->addColumn('Specialization', function($user) {
                return $user->player->specialization;
            })
            ->addColumn('Jersey no', function($user) {
                return $user->player->jersey_number;
            })

            ->addColumn('action', function ($user){
                $route = route('frontend.players.player-stats',$user->player->slug);
                return "<a href='$route' class='btn btn-outline-info me-1'><i class='fa fa-eye'></i></a> ";

            })
            ->rawColumns(['Profile','action'])
            ->setFilteredRecords($numberOfFilteredRows)
            ->setTotalRecords($numberOfTotalRows)
            ->make(true);
    }

}
