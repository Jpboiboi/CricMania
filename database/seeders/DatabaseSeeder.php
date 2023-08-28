<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\MatchDetailScorecard;
use App\Models\MatchScorecard;
use App\Models\Player;
use App\Models\User;
use App\Models\Tournament;
use App\Models\PlayerStat;
use App\Models\Team;
use App\Models\TournamentMatch;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {

        $this->call([
            TournamentTypesSeeder::class
        ]);

        \App\Models\User::factory(1000)->create()->each(function($user) {
            $specialization=['batsman','baller','all-rounder'];
            $hand=['right','left'];
            $ballingType=['fast','spin','medium-fast'];
            $player = Player::create([
                'slug' => strtolower($user->first_name) . "-" . strtolower($user->last_name),
                'dob'=>fake()->date(),
                'state'=>fake()->city(),
                'fav_playing_spot'=>rand(1,11),
                'specialization'=>$specialization[rand(0,2)],
                'balling_hand'=>$hand[rand(0,1)],
                'batting_hand'=>$hand[rand(0,1)],
                'balling_type'=>$ballingType[rand(0,2)],
                'jersey_number'=>rand(1,999),
                'user_id'=>$user->id,
            ]);
        });

        User::create([
            'first_name' => 'admin',
            'last_name' => '123',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('abcd1234'),
            'role' => 'admin',
        ]);

        Tournament::factory(5)->create()->each(function($tournament) {
            $tournament->tournament_teams()->create([
                'name' => 'TBD',
                'image_path' => "",
            ]);

            $tournament->tournament_teams()->saveMany(
                Team::factory($tournament->no_of_teams)
                    ->make())->each(function($team) use($tournament){

                        for ($i=1; $i < random_int(12, $tournament->max_players+1); $i++) {

                            $player = Player::whereHas('teams', function($teamsQuery) use($tournament) { $playersInThisTournament = DB::table('player_team')->where('tournament_id', '=', $tournament->id)->pluck('player_id')->toArray(); return $teamsQuery->whereNotIn('player_id', $playersInThisTournament); })->orWhereDoesntHave('teams')->get()->random();

                            $team->players()->attach($player->id, ['tournament_id' => $tournament->id]);
                        }
                });


            $teams = $tournament->tournament_teams;
            $teamsCount=($teams->count()-1)/2;
            $count=$teams->count()-1;
            $date=$tournament->start_date;

            for($i=1;$i<=$count;$i+=2)
            {
                $tournamentMatch = TournamentMatch::create([
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

        });

        Tournament::factory(5)->create()->each(function($tournament) {
            $tournament->tournament_teams()->create([
                'name' => 'TBD',
                'image_path' => "",
            ]);

            $tournament->tournament_teams()->saveMany(
                Team::factory($tournament->no_of_teams)
                    ->make())->each(function($team) use($tournament){

                        for ($i=1; $i < random_int(12, $tournament->max_players+1); $i++) {

                            $player = Player::whereHas('teams', function($teamsQuery) use($tournament) { $playersInThisTournament = DB::table('player_team')->where('tournament_id', '=', $tournament->id)->pluck('player_id')->toArray(); return $teamsQuery->whereNotIn('player_id', $playersInThisTournament); })->orWhereDoesntHave('teams')->get()->random();

                            $team->players()->attach($player->id, ['tournament_id' => $tournament->id]);
                        }
                });


            $teams = $tournament->tournament_teams;
            $teamsCount=($teams->count()-1)/2;
            $count=$teams->count()-1;
            $date=$tournament->start_date;

            for($i=1;$i<=$count;$i+=2)
            {
                $tournamentMatch = TournamentMatch::create([
                    'team1_id'=>$teams[$i]->id,
                    'team2_id'=>$teams[$i+1]->id,
                    'tournament_id'=>$tournament->id,
                    'match_date'=>$date,
                    'no_of_overs'=>$tournament->no_of_overs,
                ]);
                $date= Carbon::createFromFormat('Y-m-d H:i:s', $date)->addDays(1)->format('Y-m-d H:i:s');

                if($tournamentMatch->is_live) {
                    $tournamentTeams = [$tournamentMatch->team1, $tournamentMatch->team2];
                    $tournamentMatch->toss = $tournamentTeams[random_int(0,1)]->id;
                    $tournamentMatch->currently_batting = $tournamentTeams[random_int(0,1)]->id;

                    // Inning 1 batting and balling players
                    if($tournamentMatch->currently_batting === $tournamentMatch->team1->id) {
                        $battingTeamPlayers = $tournamentMatch->team1->players()->with('user')->get();
                        $bowlingTeamPlayers = $tournamentMatch->team2->players()->with('user')->get();
                    } else {
                        $battingTeamPlayers = $tournamentMatch->team2->players()->with('user')->get();
                        $bowlingTeamPlayers = $tournamentMatch->team1->players()->with('user')->get();
                    }

                    // Inning 1 strike batsman
                    $strikeBatsman = $battingTeamPlayers->random();
                    $battingTeamPlayers = $battingTeamPlayers->filter(function($player) use($strikeBatsman){
                        return $player->id != $strikeBatsman->id;
                    });
                    // Inning 1 non strike batsman
                    $nonStrikeBatsman = $battingTeamPlayers->random();
                    $battingTeamPlayers = $battingTeamPlayers->filter(function($player) use($nonStrikeBatsman){
                        return $player->id != $nonStrikeBatsman->id;
                    });

                    // Inning 1 bowler
                    $bowler = $bowlingTeamPlayers->random();

                    $matchScorecard = $tournamentMatch->matchScorecards()->create([
                        'team_id' => $tournamentMatch->currently_batting,
                        'strike_batsman_id' => $strikeBatsman->id,
                        'non_strike_batsman_id' => $nonStrikeBatsman->id,
                        'bowler_id' => $bowler->id,
                        'inning' => MatchScorecard::FIRST_INNING
                    ]);

                    $ongoingTotalRuns = 0;
                    $runsType = ['dot', 'single', 'double', 'triple', 'four', 'five', 'six'];

                    $range = ceil(($tournamentMatch->no_of_overs*6) / 10);
                    $minRange = $range - 1;
                    $maxRange = $range + 1;
                    $wicketCount = 0;
                    $ballCount = 0;

                    // Inning 1 all balls rows
                    for ($j=1 ; $j <= $tournamentMatch->no_of_overs * 6; $j++)
                    {
                        if($ballCount == 0) {
                            // After a random no of balls a wicket will be taken
                            $ballCount = random_int($minRange, $maxRange);
                        }

                        $ballCount--;

                        if($ballCount > 0) {
                            $currentRunType = $runsType[random_int(0, 5)];
                            if($currentRunType == 'dot') {
                                $runByBat = 0;
                            } else if($currentRunType == 'single') {
                                $runByBat = 1;
                                $temp = $strikeBatsman;
                                $strikeBatsman = $nonStrikeBatsman;
                                $nonStrikeBatsman = $temp;
                            } else if($currentRunType == 'double') {
                                $runByBat = 2;
                            } else if($currentRunType == 'triple') {
                                $runByBat = 3;
                                $temp = $strikeBatsman;
                                $strikeBatsman = $nonStrikeBatsman;
                                $nonStrikeBatsman = $temp;
                            } else if($currentRunType == 'four') {
                                $runByBat = 4;
                            } else if($currentRunType == 'five') {
                                $runByBat = 5;
                                $temp = $strikeBatsman;
                                $strikeBatsman = $nonStrikeBatsman;
                                $nonStrikeBatsman = $temp;
                            } else if($currentRunType == 'six') {
                                $runByBat = 6;
                            }
                            $ongoingTotalRuns += $runByBat;
                            $matchScorecard->runs_by_bat += $runByBat;

                            $strikerName = $strikeBatsman->user->first_name;
                            $bowlerName = $bowler->user->first_name;

                            $matchDetailScorecard = $matchScorecard->matchDetailScorecards()->create([
                                'bat_by' => $strikeBatsman->id,
                                'ball_by' => $bowler->id,
                                'over' => ceil($j/6),
                                'ball_number' => $j,
                                'runs_by_bat' => $runByBat,
                                'total_runs_scored' => $ongoingTotalRuns,
                                'was_' . $currentRunType => true,
                                'wickets_taken' => $wicketCount,
                                'playing_team' => $tournamentMatch->currently_batting,
                                'commentary_message' => "$strikerName hitted $runByBat runs to $bowlerName"
                            ]);


                        } else {
                            // When a player is out
                            $wicketCount++;

                            $wicketTaker = $bowlingTeamPlayers->random();

                            $strikerName = $strikeBatsman->user->first_name;
                            $bowlerName = $bowler->user->first_name;

                            $matchDetailScorecard = $matchScorecard->matchDetailScorecards()->create([
                                'bat_by' => $strikeBatsman->id,
                                'ball_by' => $bowler->id,
                                'over' => ceil($j/6),
                                'ball_number' => $j,
                                'total_runs_scored' => $ongoingTotalRuns,
                                'wickets_taken' => $wicketCount,
                                'dismissed_batsman' => $strikeBatsman->id,
                                'wicket_type' => 'bowled',
                                'out_by' => $bowler->id,
                                'playing_team' => $tournamentMatch->currently_batting,
                                'commentary_message' => "$strikerName was bowled by $bowlerName"
                            ]);


                            if($wicketCount > 9) {
                                break;
                            }

                            // Next player will be selected for batting
                            $strikeBatsman = $battingTeamPlayers->random();
                            $battingTeamPlayers = $battingTeamPlayers->filter(function($player) use($strikeBatsman){
                                return $player->id != $strikeBatsman->id;
                            });
                            $matchScorecard->strike_batsman_id = $strikeBatsman->id;
                            $matchScorecard->save();
                        }

                        // Bowler will be changed after a over(after every 6th ball)
                        if($j%6 == 0) {
                            $bowler = $bowlingTeamPlayers->random();
                            $matchScorecard->bowler_id = $bowler->id;
                            $matchScorecard->save();
                            $temp = $strikeBatsman;
                            $strikeBatsman = $nonStrikeBatsman;
                            $nonStrikeBatsman = $temp;
                        }

                        // Score is updated in the match scorecard
                        $matchScorecard->total_runs_scored = $ongoingTotalRuns;
                        $matchScorecard->save();

                    }

                    // Changing team after first innings
                    if($tournamentMatch->currently_batting === $tournamentMatch->team1->id) {
                        $tournamentMatch->currently_batting = $tournamentMatch->team2->id;
                    } else {
                        $tournamentMatch->currently_batting = $tournamentMatch->team1->id;
                    }
                    $matchScorecard->save();


                    // Inning 2 batting and balling players
                    if($tournamentMatch->currently_batting === $tournamentMatch->team1->id) {
                        $battingTeamPlayers = $tournamentMatch->team1->players()->with('user')->get();
                        $bowlingTeamPlayers = $tournamentMatch->team2->players()->with('user')->get();
                    } else {
                        $battingTeamPlayers = $tournamentMatch->team2->players()->with('user')->get();
                        $bowlingTeamPlayers = $tournamentMatch->team1->players()->with('user')->get();
                    }

                    // Inning 2 strike batsman
                    $strikeBatsman = $battingTeamPlayers->random();
                    $battingTeamPlayers = $battingTeamPlayers->filter(function($player) use($strikeBatsman){
                        return $player->id != $strikeBatsman->id;
                    });

                    // Inning 2 non strike batsman
                    $nonStrikeBatsman = $battingTeamPlayers->random();
                    $battingTeamPlayers = $battingTeamPlayers->filter(function($player) use($nonStrikeBatsman){
                        return $player->id != $nonStrikeBatsman->id;
                    });

                    // Inning 2 bowler
                    $bowler = $bowlingTeamPlayers->random();

                    $matchScorecard = $tournamentMatch->matchScorecards()->create([
                        'team_id' => $tournamentMatch->currently_batting,
                        'strike_batsman_id' => $strikeBatsman->id,
                        'non_strike_batsman_id' => $nonStrikeBatsman->id,
                        'bowler_id' => $bowler->id,
                        'inning' => MatchScorecard::SECOND_INNING
                    ]);

                    $ongoingTotalRuns = 0;
                    $runsType = ['dot', 'single', 'double', 'triple', 'four', 'five', 'six'];

                    $range = ceil(($tournamentMatch->no_of_overs*6) / 10);
                    $minRange = $range - 1;
                    $maxRange = $range + 1;
                    $wicketCount = 0;
                    $ballCount = 0;

                    // Inning 2 all balls rows
                    for ($j=1 ; $j <= $tournamentMatch->no_of_overs * 6; $j++)
                    {
                        if($ballCount == 0) {
                            // After a random no of balls a wicket will be taken
                            $ballCount = random_int($minRange, $maxRange);
                        }

                        $ballCount--;

                        if($ballCount > 0) {
                            $currentRunType = $runsType[random_int(0, 5)];
                            if($currentRunType == 'dot') {
                                $runByBat = 0;
                            } else if($currentRunType == 'single') {
                                $runByBat = 1;
                                $temp = $strikeBatsman;
                                $strikeBatsman = $nonStrikeBatsman;
                                $nonStrikeBatsman = $temp;
                            } else if($currentRunType == 'double') {
                                $runByBat = 2;
                            } else if($currentRunType == 'triple') {
                                $runByBat = 3;
                                $temp = $strikeBatsman;
                                $strikeBatsman = $nonStrikeBatsman;
                                $nonStrikeBatsman = $temp;
                            } else if($currentRunType == 'four') {
                                $runByBat = 4;
                            } else if($currentRunType == 'five') {
                                $runByBat = 5;
                                $temp = $strikeBatsman;
                                $strikeBatsman = $nonStrikeBatsman;
                                $nonStrikeBatsman = $temp;
                            } else if($currentRunType == 'six') {
                                $runByBat = 6;
                            }
                            $ongoingTotalRuns += $runByBat;
                            $matchScorecard->runs_by_bat += $runByBat;

                            $strikerName = $strikeBatsman->user->first_name;
                            $bowlerName = $bowler->user->first_name;

                            $matchDetailScorecard = $matchScorecard->matchDetailScorecards()->create([
                                'bat_by' => $strikeBatsman->id,
                                'ball_by' => $bowler->id,
                                'over' => ceil($j/6),
                                'ball_number' => $j,
                                'runs_by_bat' => $runByBat,
                                'total_runs_scored' => $ongoingTotalRuns,
                                'was_' . $currentRunType => true,
                                'wickets_taken' => $wicketCount,
                                'playing_team' => $tournamentMatch->currently_batting,
                                'commentary_message' => "$strikerName hitted $runByBat runs to $bowlerName"
                            ]);


                        } else {
                            // When a player is out
                            $wicketCount++;

                            $strikerName = $strikeBatsman->user->first_name;
                            $bowlerName = $bowler->user->first_name;

                            $matchDetailScorecard = $matchScorecard->matchDetailScorecards()->create([
                                'bat_by' => $strikeBatsman->id,
                                'ball_by' => $bowler->id,
                                'over' => ceil($j/6),
                                'ball_number' => $j,
                                'total_runs_scored' => $ongoingTotalRuns,
                                'wickets_taken' => $wicketCount,
                                'dismissed_batsman' => $strikeBatsman->id,
                                'wicket_type' => 'bowled',
                                'out_by' => $bowler->id,
                                'playing_team' => $tournamentMatch->currently_batting,
                                'commentary_message' => "$strikerName was bowled by $bowlerName"
                            ]);


                            if($wicketCount > 9) {
                                break;
                            }

                            // Next player will be selected for batting
                            $strikeBatsman = $battingTeamPlayers->random();
                            $battingTeamPlayers = $battingTeamPlayers->filter(function($player) use($strikeBatsman){
                                return $player->id != $strikeBatsman->id;
                            });
                            $matchScorecard->strike_batsman_id = $strikeBatsman->id;
                            $matchScorecard->save();
                        }

                        // Bowler will be changed after a over(after every 6th ball)
                        if($j%6 == 0) {
                            $bowler = $bowlingTeamPlayers->random();
                            $matchScorecard->bowler_id = $bowler->id;
                            $matchScorecard->save();
                            $temp = $strikeBatsman;
                            $strikeBatsman = $nonStrikeBatsman;
                            $nonStrikeBatsman = $temp;
                        }

                        // Score is updated in the match scorecard
                        $matchScorecard->total_runs_scored = $ongoingTotalRuns;
                        $matchScorecard->save();

                    }

                    $tournamentMatch->result = $tournamentMatch->matchScorecards()->orderBy('total_runs_scored', 'desc')->value('team_id');
                    $tournamentMatch->save();
                }
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

        });

        // Tournament::factory(5)->create();

    }
}
