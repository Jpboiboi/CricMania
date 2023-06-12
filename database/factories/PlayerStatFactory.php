<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlayerStat>
 */
class PlayerStatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles=['batsman','bowler','all-rounder'];

        $matches=rand(2,100);
        return [
            'role'=>$roles[rand(0,2)],
            'no_of_runs_scored'=>rand(100,1000),
            'no_of_matches'=>$matches,
            'no_of_innings'=>rand(1,$matches),
            'no_of_balls_faced'=>rand(1,500),
            'no_of_singles'=>rand(0,1000),
            'no_of_doubles'=>rand(0,500),
            'no_of_triples'=>rand(0,300),
            'no_of_fours'=>rand(0,250),
            'no_of_sixes'=>rand(0,100),
            'no_of_fifties'=>rand(0,10),
            'no_of_hundreds'=>rand(0,3),
            'no_of_lbw'=>rand(0,25),
            'no_of_stumpings'=>rand(0,25),
            'no_of_catch_outs'=>rand(0,25),
            'no_of_run_outs'=>rand(0,25),
            'no_of_bowled'=>rand(0,50),
            'no_of_wickets_taken'=>rand(0,2000),
            'no_of_balls_bowled'=>rand(0,3000),
            'no_of_runs_conceeded'=>rand(0,2000),
            'hattricks'=>rand(0,10),
            'wides'=>rand(0,100),
            'no_balls'=>rand(0,200),
            'no_of_maidens'=>rand(0,200),
            'four_wicket_hauls'=>rand(0,5),
            'five_wicket_hauls'=>rand(0,4),
            'no_of_catches'=>rand(0,500),
            'player_id'=>Player::all()->random()->id,

        ];
    }
}
