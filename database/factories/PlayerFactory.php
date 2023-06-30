<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use PharIo\Manifest\Email;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specialization=['batsman','baller','all-rounder'];
        $hand=['right','left'];
        $ballingType=['fast','spin','medium-fast'];
        $user = User::all()->random();
        return [
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
        ];
    }
}
