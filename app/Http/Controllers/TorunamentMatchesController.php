<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentMatch;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TorunamentMatchesController extends Controller
{
    public function index(Tournament $tournament)
    {
        $teams=$tournament->tournament_matches()->with('team1')->with('team2')->get();
        // dd($teams[0]->team1->name);
        return view('frontend.tournaments.schedule', compact('teams', 'tournament'));

    }
    public function store(Request $request, Tournament $tournament)
    {
        $teams = $tournament->tournament_teams;
        // dd($teams->count);
        $teamsCount=($teams->count()-1)/2;
        // dd($teamsCount);
        $date=$tournament->start_date;

        for($i=1;$i<=$teams->count()-1;$i+=2)
        {

            TournamentMatch::create([
                'team1_id'=>$teams[$i]->id,
                'team2_id'=>$teams[$i+1]->id,
                'tournament_id'=>$tournament->id,
                'match_date'=>$date,

            ]);
            $date= Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(1)->format('Y-m-d H:i:s');

        }
        $teamsCount=round($teamsCount/2,0,PHP_ROUND_HALF_UP);

        for($i=0;$i<$teamsCount;$i++)
        {
            TournamentMatch::create([
                'team1_id'=>$teams[0]->id,
                'team2_id'=>$teams[0]->id,
                'tournament_id'=>$tournament->id,
                'match_date'=>$date,
            ]);
            $date= Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(1)->format('Y-m-d H:i:s');
        }
        if($teamsCount == 3){
            $teamsCount=round($teamsCount/2,0,PHP_ROUND_HALF_UP);
        }else{
            $teamsCount=$teamsCount/2.0;
        }


        if(($teamsCount > 0.5))
        {
            for($i=0;$i<$teamsCount;$i++)
            {
                TournamentMatch::create([
                    'team1_id'=>$teams[0]->id,
                    'team2_id'=>$teams[0]->id,
                    'tournament_id'=>$tournament->id,
                    'match_date'=>$date,
                ]);
                $date= Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(1)->format('Y-m-d H:i:s');
            }
        }
        $teamsCount=$teamsCount/2;
        if(($teamsCount > 0.5))
        {
            for($i=0;$i<$teamsCount;$i++)
            {
                TournamentMatch::create([
                    'team1_id'=>$teams[0]->id,
                    'team2_id'=>$teams[0]->id,
                    'tournament_id'=>$tournament->id,
                    'match_date'=>$date,
                ]);
                $date= Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(1)->format('Y-m-d H:i:s');
            }
        }


        return redirect()->route('frontend.tournaments.schedule',$tournament->id);

    }
}
