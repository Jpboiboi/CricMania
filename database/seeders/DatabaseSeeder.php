<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {

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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'first_name' => 'admin',
            'last_name' => '123',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('abcd1234'),
            'role' => 'admin',
        ]);
            //     'name' => 'Test User',
            //     'email' => 'test@example.com',
            // ]);

        $this->call([
            TournamentTypesSeeder::class
        ]);


        Tournament::factory(5)->create()->each(function($tournament) {
            $tournament->tournament_teams()->create([
                'name' => 'TBD',
                'image_path' => "",
            ]);

            $tournament->tournament_teams()->saveMany(
                Team::factory($tournament->no_of_teams)
                    ->make())->each(function($team) use($tournament){

                        for ($i=1; $i < random_int(5, 11); $i++) {

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

        });

        // Team::factory()
        //             ->make()
        //             ->toArray()

        // \App\Models\Player::factory(10)->create();
        // \App\Models\PlayerStat::factory(10)->create();
        // \App\Models\Player::factory(20)->create()->each(function($player){
        //         $player->playerstats()->create(
        //             PlayerStat::factory()
        //             ->make()
        //             ->toArray()

        //         );
        // });



    }
}
