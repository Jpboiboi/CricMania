<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Tournament;
use App\Models\TournamentMatch;
use Illuminate\Http\Request;

class ScorersController extends Controller
{
    public function scoring(Tournament $tournament,TournamentMatch $tournamentMatch)
    {
        if(!$tournamentMatch->isMatchScorecardCreated('first')) {
            $inning = 'first';
            return view('frontend.scorer.create',compact('tournament','tournamentMatch', 'inning'));
        }
        if(!$tournamentMatch->isFirstInningCompleted()) {
            $inning = 'first';
            return view('frontend.scorer.index',compact('tournament','tournamentMatch', 'inning'));
        }
        if(!$tournamentMatch->isMatchScorecardCreated('second')) {
            $inning = 'second';
            return view('frontend.scorer.create',compact('tournament','tournamentMatch', 'inning'));
        }
        if(!$tournamentMatch->isSecondInningCompleted()) {
            $inning = 'second';
            return view('frontend.scorer.index',compact('tournament','tournamentMatch', 'inning'));
        }
        // if(!$tournamentMatch->isMatchScorecardCreated('first')) {
        //     return redirect()->route('start-scoring', [$tournament->id,$tournamentMatch->id,'inning' => 'first']);
        // }
        // if(!$tournamentMatch->isFirstInningCompleted()) {
        //     return redirect()->route('live-scoring', [$tournament->id, $tournamentMatch->id, 'inning' => 'first']);
        // }
        // if(!$tournamentMatch->isMatchScorecardCreated('second')) {
        //     return redirect()->route('start-scoring', [$tournament->id,$tournamentMatch->id,'inning' => 'second']);
        // }
        // if(!$tournamentMatch->isSecondInningCompleted()) {
        //     return redirect()->route('live-scoring', [$tournament->id,$tournamentMatch->id,'inning' => 'second']);
        // }
    }

    // public function liveScoring(Tournament $tournament,TournamentMatch $tournamentMatch)
    // {
    //     return view('frontend.scorer.index',compact('tournament','tournamentMatch'));
    // }

    // public function startScoring(Tournament $tournament,TournamentMatch $tournamentMatch)
    // {
    //     return view('frontend.scorer.create',compact('tournament','tournamentMatch'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('frontend.scorer.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        // redirect()


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
