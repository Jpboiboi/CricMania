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
        Tournament::create([
            'name' => $request->name,
            'tournament_type_id' => $request->tournament_type_id,
            'no_of_teams' => $request->no_of_teams,
            'max_players' => $request->max_players,
            'start_date' => $request->start_date,
            'organizer_id' => auth()->id()
        ]);
        return redirect()->route('tournaments.index');
    }
}
