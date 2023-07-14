<?php

namespace App\Http\Controllers;

use App\Http\Requests\tournaments\CreateTournamentRequest;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TournamentsController extends Controller
{
    public function index() {
        return view('frontend.tournaments.index');
    }

    public function create() {
        return view('frontend.tournaments.create');
    }

    public function store(CreateTournamentRequest $request) {

        if($request->single_day === 'single_day'){
            $single_day=true;
        }else{
            $single_day=false;
        }
        Tournament::create([
            'name' => $request->name,
            'tournament_type_id' => $request->tournament_type_id,
            'no_of_teams' => $request->no_of_teams,
            'max_players' => $request->max_players,
            'no_of_overs' => $request->no_of_overs,
            'start_date' => $request->start_date,
            'organizer_id' => auth()->id(),
            'is_single_day'=>$single_day,

        ]);
        return redirect()->route('tournaments.index');
    }
}
