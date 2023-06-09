<?php

namespace Database\Factories;

use App\Models\TournamentType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $no_of_teams = [4, 6, 8, 10];
        return [
            'name' => fake()->sentence(7),
            'organizer_id' => User::all()->random()->id,
            'tournament_type_id' => TournamentType::all()->random()->id,
            'no_of_teams' => $no_of_teams[random_int(0, 3)],
            'max_players' => random_int(11, 25),
            'start_date' => Carbon::now()


        ];
    }
}
