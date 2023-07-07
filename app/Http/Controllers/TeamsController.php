<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Tournament;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['validateOrganizer'])->only(['index', 'create', 'store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Tournament $tournament)
    {
        $teams = $tournament->tournament_teams;

        return view('frontend.teams.index', compact('teams', 'tournament'));

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
    public function store(Request $request ,Tournament $tournament)
    {
        // dd($request);
        $rules = [
            'teams.*.name' => 'required|unique:teams,name,NULL,id,tournament_id,'.$tournament->id,
            'teams.*.image' => 'required|image|mimes:png,jpg,svg|max:1024',
            'teams.*.email' => 'required|distinct'

        ];
        $this->validate($request , $rules);
        $teams = DB::transaction(function () use ($request, $tournament) {
            $data = ['name'=>"TBD", 'tournament_id' => $tournament->id, 'image_path' => ""];
            Team::create($data);

            $teams = [];
            foreach($request->teams as $team) {
                $image_path = ($team['image'])->store('images');

                $data = ['name'=>$team['name'], 'tournament_id' => $tournament->id];
                $data = array_merge($data, [
                    'image_path'=> $image_path,
                ]);

                $captainsEmail=$team['email'];
                $user = User::where('email', $captainsEmail)->first();

                $team = Team::create($data);
                if($user){
                    $user->addCaptain($tournament->id, $team->id, $user->player->id);
                }else{
                    User::registerCaptain($captainsEmail,$tournament->id, $team->id);
                }

                $teams[]= $team;
            }

            return $teams;
        });
        session()->flash('success', 'Team Created Successfully...');
        return view('frontend.teams.index', compact(['tournament', 'teams']));
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
