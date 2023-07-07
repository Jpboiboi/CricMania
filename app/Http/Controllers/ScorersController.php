<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class ScorersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $ballers = ->players->where('specialization','baller')->pluck('id');
        // $batsman = ->players->where('specialization','batsman')->pluck('id');



    }

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
        return view('frontend.scorer.index');

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
