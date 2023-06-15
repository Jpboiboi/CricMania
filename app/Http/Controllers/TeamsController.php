<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\CreateTeamsRequest;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.teams.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Tournament $tournament)
    {

        // return view('teams.create');
        return view('frontend.teams.create', compact('tournament'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $teams = [];

        foreach($request->teams as $team) {
            $image_path = ($team['image'])->store('images');

            $data = ['name'=>$team['name']];
            $data = array_merge($data, [
                'image_path'=> $image_path,
            ]);
            $team = Team::create($data);
            session()->flash('success', 'Team Created Successfully...');
            $teams[]= $team;
        }
        return view('frontend.teams.index', compact('teams'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
