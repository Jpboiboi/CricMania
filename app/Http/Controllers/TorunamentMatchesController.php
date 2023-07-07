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
        return view('frontend.tournaments.schedule', compact('teams', 'tournament'));

    }
    public function store(Request $request, Tournament $tournament)
    {
        $teams = $tournament->tournament_teams;
        $teamsCount=($teams->count()-1)/2;
        $count=$teams->count()-1;
        $date=$tournament->start_date;

        for($i=1;$i<=$count;$i+=2)
        {

            TournamentMatch::create([
                'team1_id'=>$teams[$i]->id,
                'team2_id'=>$teams[$i+1]->id,
                'tournament_id'=>$tournament->id,
                'match_date'=>$date,
                'no_of_overs'=>$tournament->no_of_overs,
            ]);
            $date= Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(1)->format('Y-m-d H:i:s');

        }
        $teamsCount=intval(round($teamsCount/2,0,PHP_ROUND_HALF_DOWN));

        while($teamsCount>0){
            TournamentMatch::create([
                'team1_id'=>$teams[0]->id,
                'team2_id'=>$teams[0]->id,
                'tournament_id'=>$tournament->id,
                'match_date'=>$date,
                'no_of_overs'=>$tournament->no_of_overs
            ]);
            $date= Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(1)->format('Y-m-d H:i:s');
            $teamsCount=intval(round($teamsCount/2,0,PHP_ROUND_HALF_DOWN));
        }

        if($count === 6 || $count === 8){
            TournamentMatch::create([
                'team1_id'=>$teams[0]->id,
                'team2_id'=>$teams[0]->id,
                'tournament_id'=>$tournament->id,
                'match_date'=>$date,
                'no_of_overs'=>$tournament->no_of_overs
            ]);
            $date= Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(1)->format('Y-m-d H:i:s');
        }
        if($count === 10){
            for($i=0;$i<2;$i++){
                TournamentMatch::create([
                    'team1_id'=>$teams[0]->id,
                    'team2_id'=>$teams[0]->id,
                    'tournament_id'=>$tournament->id,
                    'match_date'=>$date,
                    'no_of_overs'=>$tournament->no_of_overs
                ]);
                $date= Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(1)->format('Y-m-d H:i:s');
            }

        }

        return redirect()->route('frontend.tournaments.schedule',$tournament->id);

    }
}
